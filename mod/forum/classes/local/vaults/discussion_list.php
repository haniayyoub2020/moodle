<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Vault class for a discussion list.
 *
 * @package    mod_forum
 * @copyright  2019 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_forum\local\vaults;

defined('MOODLE_INTERNAL') || die();

use mod_forum\local\vaults\preprocessors\extract_record as extract_record_preprocessor;
use mod_forum\local\vaults\preprocessors\extract_user as extract_user_preprocessor;
use mod_forum\local\renderers\discussion_list as discussion_list_renderer;
use core\dml\table as dml_table;
use stdClass;

/**
 * Discussion list vault.
 *
 * This should be the only place that accessed the database.
 *
 * This uses the repository pattern. See:
 * https://designpatternsphp.readthedocs.io/en/latest/More/Repository/README.html
 *
 * @package    mod_forum
 * @copyright  2019 Andrew Nicols <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class discussion_list extends db_table_vault {
    /** The table for this vault */
    private const TABLE = 'forum_discussions';
    /** Alias for first author id */
    private const FIRST_AUTHOR_ID_ALIAS = 'fauserpictureid';
    /** Alias for author fields */
    private const FIRST_AUTHOR_ALIAS = 'fauserrecord';
    /** Alias for last author id */
    private const LATEST_AUTHOR_ID_ALIAS = 'lauserpictureid';
    /** Alias for last author fields */
    private const LATEST_AUTHOR_ALIAS = 'lauserrecord';
    /** Default limit */
    public const PAGESIZE_DEFAULT = 100;

    /** Sort by newest first */
    public const SORTORDER_LASTPOST_DESC = 1;
    /** Sort by oldest first */
    public const SORTORDER_LASTPOST_ASC = 2;
    /** Sort by created desc */
    public const SORTORDER_CREATED_DESC = 3;
    /** Sort by created asc */
    public const SORTORDER_CREATED_ASC = 4;
    /** Sort by number of replies desc */
    public const SORTORDER_REPLIES_DESC = 5;
    /** Sort by number of replies desc */
    public const SORTORDER_REPLIES_ASC = 6;

    /**
     * Get the table alias.
     *
     * @return string
     */
    protected function get_table_alias() : string {
        return 'd';
    }

    /**
     * Get the favourite table alias
     *
     * @return string
     */
    protected function get_favourite_alias() : string {
        return 'favalias';
    }

    /**
     * Build the SQL to be used in get_records_sql.
     *
     * @param string|null $wheresql Where conditions for the SQL
     * @param string|null $sortsql Order by conditions for the SQL
     * @param string|null $joinsql Additional join conditions for the sql
     * @param int|null    $userid The ID of the user we are performing this query for
     *
     * @return string
     */
    protected function generate_get_records_sql(string $wheresql = null, string $privatereplywhere = null, ?string $sortsql = null, ?int $userid = null) : string {
        $alias = $this->get_table_alias();
        $db = $this->get_db();

        $includefavourites = $userid ? true : false;

        $favsql = '';
        if ($includefavourites) {
            list($favsql, $favparams) = $this->get_favourite_sql($userid);
            foreach ($favparams as $key => $param) {
                $favsql = str_replace(":$key", "'$param'", $favsql);
            }
        }

        // Fetch:
        // - Discussion
        // - First post
        // - Author
        // - Most recent editor.
        $thistable = new dml_table(self::TABLE, $alias, $alias);
        $firstposttable = new dml_table('forum_posts', 'fp', 'fp_');
        $lastposttable = new dml_table('forum_posts', 'lp', 'lp_');
        $firstauthorfields = \user_picture::fields('fa', null, self::FIRST_AUTHOR_ID_ALIAS, self::FIRST_AUTHOR_ALIAS);
        $latestuserfields = \user_picture::fields('la', null, self::LATEST_AUTHOR_ID_ALIAS, self::LATEST_AUTHOR_ALIAS);

        $fields = implode(', ', [
            $thistable->get_field_select(),
            $firstposttable->get_field_select(),
            $lastposttable->get_field_select(),
            $firstauthorfields,
            "dsource.lastpost",
            $latestuserfields,
        ]);

        $sortkeys = [
            $this->get_sort_order(self::SORTORDER_REPLIES_DESC, $includefavourites),
            $this->get_sort_order(self::SORTORDER_REPLIES_ASC, $includefavourites)
        ];
        $issortbyreplies = in_array($sortsql, $sortkeys);

        $wheresql = preg_replace("/{$alias}\./", "di.", $wheresql);

        if (!empty($privatereplywhere)) {
            $privatereplywhere = "WHERE {$privatereplywhere}";
        }

        $tables = $thistable->get_from_sql();
        $tables .= <<<SQL

                INNER JOIN (
                    SELECT
                        di.id, pi.id as lastpost
                      FROM {forum_discussions} di
                      JOIN (
                        SELECT
                            pnewest.id,
                            pnewest.discussion, row_number() OVER (PARTITION BY discussion ORDER BY created DESC, id DESC) AS rowno
                          FROM {forum_posts} pnewest
                          {$privatereplywhere}
                      ) pn ON pn.discussion = di.id AND pn.rowno = 1
                      JOIN {forum_posts} pi ON pi.id = pn.id
                     WHERE {$wheresql}
                ) dsource ON dsource.id = {$alias}.id
SQL;
        $tables .= ' JOIN {user} fa ON fa.id = ' . $alias . '.userid';
        $tables .= ' JOIN ' . $firstposttable->get_from_sql() . ' ON fp.id = ' . $alias . '.firstpost';
        $tables .= ' JOIN ' . $lastposttable->get_from_sql() . ' ON lp.id = dsource.lastpost';
        $tables .= ' JOIN {user} la ON la.id = lp.userid';
        $tables .= $favsql;

        if ($issortbyreplies) {
            // Join the discussion replies.
            $tables .= ' JOIN (
                            SELECT rd.id, COUNT(rp.id) as replycount
                            FROM {forum_discussions} rd
                            LEFT JOIN {forum_posts} rp
                                ON rp.discussion = rd.id AND rp.id != rd.firstpost
                            GROUP BY rd.id
                         ) r ON d.id = r.id';
        }

        $selectsql = 'SELECT ' . $fields . ' FROM ' . $tables;
        $selectsql .= $sortsql ? ' ORDER BY ' . $sortsql : '';

        return $selectsql;
    }

    /**
     * Build the SQL to be used in count_records_sql.
     *
     * @param string|null $wheresql Where conditions for the SQL
     * @return string
     */
    protected function generate_count_records_sql(string $wheresql = null) : string {
        $alias = $this->get_table_alias();
        $db = $this->get_db();

        $selectsql = "SELECT COUNT(1) FROM {" . self::TABLE . "} {$alias}";
        $selectsql .= $wheresql ? ' WHERE ' . $wheresql : '';

        return $selectsql;
    }

    /**
     * Get a list of preprocessors to execute on the DB results before being converted
     * into entities.
     *
     * @return array
     */
    protected function get_preprocessors() : array {
        return array_merge(
            parent::get_preprocessors(),
            [
                'discussion' => new extract_record_preprocessor(self::TABLE, $this->get_table_alias()),
                'firstpost' => new extract_record_preprocessor('forum_posts', 'fp_'),
                'lastpost' => new extract_record_preprocessor('forum_posts', 'lp_'),
                'firstpostauthor' => new extract_user_preprocessor(self::FIRST_AUTHOR_ID_ALIAS, self::FIRST_AUTHOR_ALIAS),
                'latestpostauthor' => new extract_user_preprocessor(self::LATEST_AUTHOR_ID_ALIAS, self::LATEST_AUTHOR_ALIAS),
            ]
        );
    }

    /**
     * Convert the DB records into discussion list entities.
     *
     * @param array $results The DB records
     * @return discussion_list[]
     */
    protected function from_db_records(array $results) {
        $entityfactory = $this->get_entity_factory();

        return array_map(function(array $result) use ($entityfactory) {
            [
                'discussion' => $discussion,
                'firstpost' => $firstpost,
                'lastpost' => $lastpost,
                'firstpostauthor' => $firstpostauthor,
                'latestpostauthor' => $latestpostauthor,
            ] = $result;
            return $entityfactory->get_discussion_summary_from_stdclass(
                $discussion,
                $firstpost,
                $lastpost,
                $firstpostauthor,
                $latestpostauthor
            );
        }, $results);
    }

    /**
     * Get the field to sort by.
     *
     * @param int|null $sortmethod
     * @return string
     */
    protected function get_keyfield(?int $sortmethod) : string {
        switch ($sortmethod) {
            case self::SORTORDER_CREATED_DESC:
            case self::SORTORDER_CREATED_ASC:
                return 'fp.created';
            case self::SORTORDER_REPLIES_DESC:
            case self::SORTORDER_REPLIES_ASC:
                return 'replycount';
            default:
                global $CFG;
                $alias = $this->get_table_alias();
                $field = "{$alias}.timemodified";
                if (!empty($CFG->forum_enabletimedposts)) {
                    return "CASE WHEN {$field} < {$alias}.timestart THEN {$alias}.timestart ELSE {$field} END";
                }
                return $field;
        }
    }

    /**
     * Get the sort direction.
     *
     * @param int|null $sortmethod
     * @return string
     */
    protected function get_sort_direction(?int $sortmethod) : string {
        switch ($sortmethod) {
            case self::SORTORDER_LASTPOST_ASC:
            case self::SORTORDER_CREATED_ASC:
            case self::SORTORDER_REPLIES_ASC:
                return "ASC";
            case self::SORTORDER_LASTPOST_DESC:
            case self::SORTORDER_CREATED_DESC:
            case self::SORTORDER_REPLIES_DESC:
                return "DESC";
            default:
                return "DESC";
        }
    }

    /**
     * Get the sort order SQL for a sort method.
     *
     * @param int|null  $sortmethod
     * @param bool|null $includefavourites
     * @return string
     */
    private function get_sort_order(?int $sortmethod, bool $includefavourites = true) : string {

        $alias = $this->get_table_alias();
        // TODO consider user favourites...
        $keyfield = $this->get_keyfield($sortmethod);
        $direction = $this->get_sort_direction($sortmethod);

        $favouritesort = '';
        if ($includefavourites) {
            $favalias = $this->get_favourite_alias();
            // Since we're joining on the favourite table any discussion that isn't favourited will have
            // null in the favourite columns. Nulls behave differently in the sorting for different databases.
            // We can ensure consistency between databases by explicitly deprioritising any null favourite field
            // using a case statement.
            $favouritesort = ", CASE WHEN {$favalias}.id IS NULL THEN 0 ELSE 1 END DESC";
            // After the null favourite fields are deprioritised and appear below the favourited discussions we
            // need to order the favourited discussions by id so that the most recently favourited discussions
            // appear at the top of the list.
            $favouritesort .= ", {$favalias}.itemtype DESC";
        }

        return "{$alias}.pinned DESC $favouritesort , {$keyfield} {$direction}";
    }

    /**
     * Fetch any required SQL to respect timed posts.
     *
     * @param   bool        $includehiddendiscussions Whether to include hidden discussions or not
     * @param   int|null    $includepostsforuser Which user to include posts for, if any
     * @return  array       The SQL and parameters to include
     */
    protected function get_hidden_post_sql(bool $includehiddendiscussions, ?int $includepostsforuser) {
        $wheresql = '';
        $params = [];
        if (!$includehiddendiscussions) {
            $now = time();
            $wheresql = "((d.timestart <= :timestart AND (d.timeend = 0 OR d.timeend > :timeend))";
            $params['timestart'] = $now;
            $params['timeend'] = $now;
            if (null !== $includepostsforuser) {
                $wheresql .= " OR d.userid = :byuser";
                $params['byuser'] = $includepostsforuser;
            }
            $wheresql .= ")";
        }

        return [
            'wheresql' => $wheresql,
            'params' => $params,
        ];
    }

    /**
     * Get each discussion, first post, first and last post author for the given forum, considering timed posts, and
     * pagination.
     *
     * @param   int         $forumid The forum to fetch the discussion set for
     * @param   bool        $includehiddendiscussions Whether to include hidden discussions or not
     * @param   int|null    $includepostsforuser Which user to include posts for, if any
     * @param   int         $sortorder The sort order to use
     * @param   int         $limit The number of discussions to fetch
     * @param   int         $offset The record offset
     * @return  array       The set of data fetched
     */
    public function get_from_forum_id(
        int $forumid,
        bool $includehiddendiscussions,
        ?int $includepostsforuser,
        ?int $sortorder,
        int $limit,
        int $offset
    ) {
        $alias = $this->get_table_alias();
        $wheresql = ["{$alias}.forum = :forumid"];
        [
            'wheresql' => $hiddensql,
            'params' => $hiddenparams
        ] = $this->get_hidden_post_sql($includehiddendiscussions, $includepostsforuser);
        $wheresql[] = $hiddensql;

        $params = array_merge($hiddenparams, [
            'forumid' => $forumid,
        ]);


        $userid = $includepostsforuser;
        $canseeprivatereplies = false;
        [
            'where' => $privatewhere,
            'params' => $privateparams,
        ] = $this->get_private_reply_sql($userid, $canseeprivatereplies, 'pnewest');
        $params = array_merge($params, $privateparams);

        $wheresql = implode(' AND ', $wheresql);

        $includefavourites = $includepostsforuser ? true : false;
        $sql = $this->generate_get_records_sql($wheresql, $privatewhere, $this->get_sort_order($sortorder, $includefavourites),
            $includepostsforuser);
        $records = $this->get_db()->get_records_sql($sql, $params, $offset, $limit);

        return $this->transform_db_records_to_entities($records);
    }

    /**
     * Get each discussion, first post, first and last post author for the given forum, and the set of groups to display
     * considering timed posts, and pagination.
     *
     * @param   int         $forumid The forum to fetch the discussion set for
     * @param   int[]       $groupids The list of real groups to filter on
     * @param   bool        $includehiddendiscussions Whether to include hidden discussions or not
     * @param   int|null    $includepostsforuser Which user to include posts for, if any
     * @param   int         $sortorder The sort order to use
     * @param   int         $limit The number of discussions to fetch
     * @param   int         $offset The record offset
     * @return  array       The set of data fetched
     */
    public function get_from_forum_id_and_group_id(
        int $forumid,
        array $groupids,
        bool $includehiddendiscussions,
        ?int $includepostsforuser,
        ?int $sortorder,
        int $limit,
        int $offset
    ) {
        $alias = $this->get_table_alias();

        $wheresql = "{$alias}.forum = :forumid AND ";
        $groupparams = [];
        if (empty($groupids)) {
            $wheresql .= "{$alias}.groupid = :allgroupsid";
        } else {
            list($insql, $groupparams) = $this->get_db()->get_in_or_equal($groupids, SQL_PARAMS_NAMED, 'gid');
            $wheresql .= "({$alias}.groupid = :allgroupsid OR {$alias}.groupid {$insql})";
        }

        [
            'wheresql' => $hiddensql,
            'params' => $hiddenparams
        ] = $this->get_hidden_post_sql($includehiddendiscussions, $includepostsforuser);
        $wheresql .= $hiddensql;

        $params = array_merge($hiddenparams, $groupparams, [
            'forumid' => $forumid,
            'allgroupsid' => -1,
        ]);

        $includefavourites = $includepostsforuser ? true : false;
        $sql = $this->generate_get_records_sql($wheresql, $this->get_sort_order($sortorder, $includefavourites),
            $includepostsforuser);
        $records = $this->get_db()->get_records_sql($sql, $params, $offset, $limit);

        return $this->transform_db_records_to_entities($records);
    }

    /**
     * Count the number of discussions in the forum.
     *
     * @param int $forumid Id of the forum to count discussions in
     * @param bool $includehiddendiscussions Include hidden dicussions in the count?
     * @param int|null $includepostsforuser Include discussions created by this user in the count
     *                                      (only works if not including hidden discussions).
     * @return int
     */
    public function get_total_discussion_count_from_forum_id(
        int $forumid,
        bool $includehiddendiscussions,
        ?int $includepostsforuser
    ) {
        $alias = $this->get_table_alias();

        $wheresql = "{$alias}.forum = :forumid";

        [
            'wheresql' => $hiddensql,
            'params' => $hiddenparams
        ] = $this->get_hidden_post_sql($includehiddendiscussions, $includepostsforuser);
        $wheresql .= $hiddensql;

        $params = array_merge($hiddenparams, [
            'forumid' => $forumid,
        ]);

        return 1;
        return $this->get_db()->count_records_sql($this->generate_count_records_sql($wheresql), $params);
    }

    /**
     * Count the number of discussions in all groups and the list of groups provided.
     *
     * @param int $forumid Id of the forum to count discussions in
     * @param int[] $groupids List of group ids to include in the count (discussions in all groups will always be counted)
     * @param bool $includehiddendiscussions Include hidden dicussions in the count?
     * @param int|null $includepostsforuser Include discussions created by this user in the count
     *                                      (only works if not including hidden discussions).
     * @return int
     */
    public function get_total_discussion_count_from_forum_id_and_group_id(
        int $forumid,
        array $groupids,
        bool $includehiddendiscussions,
        ?int $includepostsforuser
    ) {
        $alias = $this->get_table_alias();

        $wheresql = "{$alias}.forum = :forumid AND ";
        $groupparams = [];
        if (empty($groupids)) {
            $wheresql .= "{$alias}.groupid = :allgroupsid";
        } else {
            list($insql, $groupparams) = $this->get_db()->get_in_or_equal($groupids, SQL_PARAMS_NAMED, 'gid');
            $wheresql .= "({$alias}.groupid = :allgroupsid OR {$alias}.groupid {$insql})";
        }

        [
            'wheresql' => $hiddensql,
            'params' => $hiddenparams
        ] = $this->get_hidden_post_sql($includehiddendiscussions, $includepostsforuser);
        $wheresql .= $hiddensql;

        $params = array_merge($hiddenparams, $groupparams, [
            'forumid' => $forumid,
            'allgroupsid' => -1,
        ]);

        return $this->get_db()->count_records_sql($this->generate_count_records_sql($wheresql), $params);
    }

    /**
     * Get the standard favouriting sql.
     *
     * @param int $userid The ID of the user we are getting the sql for
     * @return [$sql, $params] An array comprising of the sql and any associated params
     */
    private function get_favourite_sql(int $userid): array {

        $usercontext = \context_user::instance($userid);
        $alias = $this->get_table_alias();
        $ufservice = \core_favourites\service_factory::get_service_for_user_context($usercontext);
        list($favsql, $favparams) = $ufservice->get_join_sql_by_type('mod_forum', 'discussions',
            $this->get_favourite_alias(), "$alias.id");

        return [$favsql, $favparams];
    }

    /**
     * Get the SQL where and additional parameters to use to restrict posts to private reply posts.
     *
     * @param   int         $userid The user to fetch counts for
     * @param   bool        $canseeprivatereplies Whether this user can see all private replies or not
     * @return  array       The SQL WHERE clause, and parameters to use in the SQL.
     */
    private function get_private_reply_sql(int $userid, bool $canseeprivatereplies, $posttablealias = "pi") {
        $params = [];
        $privatewhere = '';
        if (!$canseeprivatereplies) {
            $privatewhere = '(' . $posttablealias . '.privatereplyto = :privatereplyto OR '
                . $posttablealias . '.userid = :privatereplyfrom OR ' . $posttablealias . '.privatereplyto = 0)';
            $params['privatereplyto'] = $userid;
            $params['privatereplyfrom'] = $userid;
        }

        return [
            'where' => $privatewhere,
            'params' => $params,
        ];
    }
}
