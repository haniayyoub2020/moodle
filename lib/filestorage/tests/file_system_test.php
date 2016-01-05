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
 * Unit tests for /lib/filelib.php.
 *
 * @package   core_files
 * @category  phpunit
 * @copyright 2009 Jerome Mouneyrac
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->libdir . '/filestorage/file_system.php');

class core_files_file_system_testcase extends advanced_testcase {

    public function setUp() {
        get_file_storage(true);
    }

    public function tearDown() {
        get_file_storage(true);
    }

    /**
     * Helper function to help setup and configure the virtual file system stream.
     *
     * @param   array $filedir Directory structure and content of the filedir
     * @param   array $trashdir Directory structure and content of the sourcedir
     * @param   array $sourcedir Directory structure and content of a directory used for source files for tests
     * @return  \org\bovigo\vfs\vfsStream
     */
    protected function setup_vfile_root($content = []) {
        $vfileroot = \org\bovigo\vfs\vfsStream::setup('root', null, $content);

        return $vfileroot;
    }

    /**
     * Helper to create a stored file objectw with the given supplied content.
     *
     * @return stored_file
     */
    protected function get_stored_file($filecontent, $filename = null, $mockedmethods = null) {
        $contenthash = sha1($filecontent);
        if (empty($filename)) {
            $filename = $contenthash;
        }

        $file = $this->getMockBuilder(stored_file::class)
            ->setMethods($mockedmethods)
            ->setConstructorArgs([
                get_file_storage(),
                (object) [
                    'contenthash' => $contenthash,
                    'filesize' => strlen($filecontent),
                    'filename' => $filename,
                ]
            ])
            ->getMock();

        return $file;
    }

    /**
     * Get a testable mock of the abstract file_system class.
     *
     * @return file_system
     */
    protected function get_testable_mock($mockedmethods = []) {
        $fs = $this->getMockBuilder(file_system::class)
            ->setMethods($mockedmethods)
            ->setConstructorArgs([get_file_storage()])
            ->getMockForAbstractClass();

        return $fs;
    }

    /**
     * Ensure that the file system is not clonable.
     */
    public function test_not_cloneable() {
        $reflection = new ReflectionClass('file_system');
        $this->assertFalse($reflection->isCloneable());
    }

    /**
     * Ensure that the filedir file_system extension is used by default.
     */
    public function test_default_class() {
        $this->resetAfterTest();

        // Ensure that the filesystem_handler_class is null.
        global $CFG;
        $CFG->filesystem_handler_class = null;

        $storage = get_file_storage();
        $fs = $storage->get_file_system();
        $this->assertInstanceOf(file_system::class, $fs);
        $this->assertEquals(file_system_filedir::class, get_class($fs));
    }

    /**
     * Ensure that the specified file_system extension class is used.
     */
    public function test_supplied_class() {
        global $CFG;
        $this->resetAfterTest();

        // Mock the file_system.
        // Mocks create a new child of the mocked class which is perfect for this test.
        $filesystem = $this->getMockBuilder('file_system')
            ->disableOriginalConstructor()
            ->getMock()
            ;
        $CFG->filesystem_handler_class = get_class($filesystem);

        $storage = get_file_storage();
        $fs = $storage->get_file_system();
        $this->assertInstanceOf(file_system::class, $fs);
        $this->assertEquals(get_class($filesystem), get_class($fs));
    }

    /**
     * Test that the readfile function outputs content to disk.
     */
    public function test_readfile() {
        global $CFG;

        // Mock the filesystem.
        $filecontent = 'example content';
        $vfileroot = $this->setup_vfile_root(['sourcefile' => $filecontent]);
        $filepath = \org\bovigo\vfs\vfsStream::url('root/sourcefile');

        $file = $this->get_stored_file($filecontent);

        // Mock the file_system class.
        // We need to override the get_remote_path_from_storedfile function.
        $fs = $this->get_testable_mock(['get_remote_path_from_storedfile']);
        $fs->method('get_remote_path_from_storedfile')->willReturn($filepath);

        // Note: It is currently not possible to mock readfile_allow_large
        // because file_system is in the global namespace.
        // We must therefore check for expected output. This is not ideal.
        $this->expectOutputString($filecontent);
        $fs->readfile($file);
    }

    /**
     * Test that the get_local_path_from_storedfile function functions
     * correctly when called with various args.
     *
     * @dataProvider get_local_path_from_storedfile_provider
     */
    public function test_get_local_path_from_storedfile($args, $fetch) {
        $filepath = '/path/to/file';
        $filecontent = 'example content';

        // Get the filesystem mock.
        $fs = $this->get_testable_mock([
            'get_local_path_from_hash',
        ]);
        $fs->expects($this->once())
            ->method('get_local_path_from_hash')
            ->with($this->equalTo(sha1($filecontent)), $this->equalTo($fetch))
            ->willReturn($filepath);

        $file = $this->get_stored_file($filecontent);

        $method = new ReflectionMethod(file_system::class, 'get_local_path_from_storedfile');
        $method->setAccessible(true);
        $result = $method->invokeArgs($fs, array_merge([$file], $args));

        $this->assertEquals($filepath, $result);
    }

    /**
     * Ensure that the default implementation of get_remote_path_from_storedfile
     * simply calls get_local_path_from_storedfile without requiring a
     * fetch.
     */
    public function test_get_remote_path_from_storedfile() {
        $filepath = '/path/to/file';
        $filecontent = 'example content';

        $fs = $this->get_testable_mock([
            'get_local_path_from_hash',
        ]);

        $fs->expects($this->once())
            ->method('get_local_path_from_hash')
            ->with($this->equalTo(sha1($filecontent)), $this->equalTo(false))
            ->willReturn($filepath);

        $file = $this->get_stored_file($filecontent);

        $method = new ReflectionMethod(file_system::class, 'get_remote_path_from_storedfile');
        $method->setAccessible(true);
        $result = $method->invokeArgs($fs, [$file]);

        $this->assertEquals($filepath, $result);
    }

    /**
     * Ensure that the default implementation of get_remote_path_from_hash
     * simply calls get_local_path_from_hash.
     */
    public function test_get_remote_path_from_hash() {
        global $CFG;

        $filepath = '/path/to/file';

        $fs = $this->get_testable_mock([
            'get_local_path_from_hash',
        ]);

        $fs->expects($this->once())
            ->method('get_local_path_from_hash')
            ->willReturn($filepath);

        $method = new ReflectionMethod(file_system::class, 'get_remote_path_from_hash');
        $method->setAccessible(true);
        $result = $method->invokeArgs($fs, ['example']);

        $this->assertEquals($filepath, $result);
    }

    /**
     * Test the stock implementation of is_readable_locally_by_hash with a valid file.
     *
     * This should call get_local_path_from_hash and check the readability
     * of the file.
     *
     * Fetching the file is optional.
     */
    public function test_is_readable_locally_by_hash() {
        $filecontent = 'example content';
        $contenthash = sha1($filecontent);
        $filepath = __FILE__;

        $fs = $this->get_testable_mock([
            'get_local_path_from_hash',
        ]);

        $fs->method('get_local_path_from_hash')
            ->with($this->equalTo($contenthash), $this->equalTo(false))
            ->willReturn($filepath);

        $this->assertTrue($fs->is_readable_locally_by_hash($contenthash));
    }

    /**
     * Test the stock implementation of is_readable_by_storedfile with a valid file.
     */
    public function test_is_readable_by_hash() {
        $filecontent = 'example content';
        $contenthash = sha1($filecontent);
        $expectedresult = (object) [];

        $fs = $this->get_testable_mock([
            'is_readable_locally_by_hash',
        ]);

        $fs->method('is_readable_locally_by_hash')
            ->with($this->equalTo($contenthash), $this->equalTo(false))
            ->willReturn($expectedresult);

        $this->assertEquals($expectedresult, $fs->is_readable_by_hash($contenthash));
    }

    /**
     * Test the stock implementation of is_readable_by_storedfile with a valid file.
     */
    public function test_is_readable_by_storedfile() {
        $file = $this->get_stored_file('example content');
        $expectedresult = (object) [];

        $fs = $this->get_testable_mock([
            'is_readable_locally_by_storedfile',
        ]);

        $fs->method('is_readable_locally_by_storedfile')
            ->willReturn($expectedresult);

        $this->assertEquals($expectedresult, $fs->is_readable_by_storedfile($file));
    }

    /**
     * Test the stock implementation of is_readable_locally_by_storedfile with a valid file.
     */
    public function test_is_readable_locally_by_storedfile() {
        $fs = $this->get_testable_mock([
            'get_local_path_from_storedfile',
            'try_content_recovery',
        ]);

        $fs->method('get_local_path_from_storedfile')
            ->willReturn(__FILE__);

        $fs->expects($this->never())
            ->method('try_content_recovery');

        $file = $this->get_stored_file('example content');
        $this->assertTrue($fs->is_readable_locally_by_storedfile($file));
    }

    /**
     * Test the stock implementation of is_readable_locally_by_storedfile with no file found and
     * a failed recovery.
     */
    public function test_is_readable_locally_with_failed_recovery() {
        $fs = $this->get_testable_mock([
            'get_local_path_from_storedfile',
            'try_content_recovery',
        ]);

        $fs->method('get_local_path_from_storedfile')
            ->willReturn('/path/to/nonexistent/file');

        $fs->method('try_content_recovery')
            ->willReturn(false);

        $file = $this->get_stored_file('example content');
        $this->assertFalse($fs->is_readable_locally_by_storedfile($file));
    }

    /**
     * Test the stock implementation of is_readable_locally_by_storedfile fwith no file found and
     * a successful recovery.
     */
    public function test_is_readable_locally_with_successful_recovery() {
        $fs = $this->get_testable_mock([
            'get_local_path_from_storedfile',
            'try_content_recovery',
        ]);

        $fs->method('get_local_path_from_storedfile')
            ->willReturn('/path/to/nonexistent/file');

        $fs->method('try_content_recovery')
            ->willReturn(true);

        $file = $this->get_stored_file('example content');
        $this->assertTrue($fs->is_readable_locally_by_storedfile($file));
    }

    /**
     * Test the stock implementation of get_content.
     */
    public function test_get_content() {
        global $CFG;

        // Mock the filesystem.
        $filecontent = 'example content';
        $vfileroot = $this->setup_vfile_root(['sourcefile' => $filecontent]);
        $filepath = \org\bovigo\vfs\vfsStream::url('root/sourcefile');

        $file = $this->get_stored_file($filecontent);

        // Mock the file_system class.
        // We need to override the get_remote_path_from_storedfile function.
        $fs = $this->get_testable_mock(['get_remote_path_from_storedfile']);
        $fs->method('get_remote_path_from_storedfile')->willReturn($filepath);

        $result = $fs->get_content($file);

        $this->assertEquals($filecontent, $result);
    }

    /**
     * Ensure that the list_files function requires a local copy of the
     * file, and passes the path to the packer.
     */
    public function test_list_files() {
        $filecontent = 'example content';
        $file = $this->get_stored_file($filecontent);
        $filepath = __FILE__;
        $expectedresult = (object) [];

        // Mock the file_system class.
        $fs = $this->get_testable_mock(['get_local_path_from_storedfile']);
        $fs->method('get_local_path_from_storedfile')
            ->with($this->equalTo($file), $this->equalTo(true))
            ->willReturn(__FILE__);

        $packer = $this->getMockBuilder(file_packer::class)
            ->setMethods(['list_files'])
            ->getMockForAbstractClass();

        $packer->expects($this->once())
            ->method('list_files')
            ->with($this->equalTo($filepath))
            ->willReturn($expectedresult);

        $result = $fs->list_files($file, $packer);

        $this->assertEquals($expectedresult, $result);
    }

    /**
     * Ensure that the extract_to_pathname function requires a local copy of the
     * file, and passes the path to the packer.
     */
    public function test_extract_to_pathname() {
        $filecontent = 'example content';
        $file = $this->get_stored_file($filecontent);
        $filepath = __FILE__;
        $expectedresult = (object) [];
        $outputpath = '/path/to/output';

        // Mock the file_system class.
        $fs = $this->get_testable_mock(['get_local_path_from_storedfile']);
        $fs->method('get_local_path_from_storedfile')
            ->with($this->equalTo($file), $this->equalTo(true))
            ->willReturn(__FILE__);

        $packer = $this->getMockBuilder(file_packer::class)
            ->setMethods(['extract_to_pathname'])
            ->getMockForAbstractClass();

        $packer->expects($this->once())
            ->method('extract_to_pathname')
            ->with($this->equalTo($filepath), $this->equalTo($outputpath), $this->equalTo(null), $this->equalTo(null))
            ->willReturn($expectedresult);

        $result = $fs->extract_to_pathname($file, $packer, $outputpath);

        $this->assertEquals($expectedresult, $result);
    }

    /**
     * Ensure that the extract_to_storage function requires a local copy of the
     * file, and passes the path to the packer.
     */
    public function test_extract_to_storage() {
        $filecontent = 'example content';
        $file = $this->get_stored_file($filecontent);
        $filepath = __FILE__;
        $expectedresult = (object) [];
        $outputpath = '/path/to/output';

        // Mock the file_system class.
        $fs = $this->get_testable_mock(['get_local_path_from_storedfile']);
        $fs->method('get_local_path_from_storedfile')
            ->with($this->equalTo($file), $this->equalTo(true))
            ->willReturn(__FILE__);

        $packer = $this->getMockBuilder(file_packer::class)
            ->setMethods(['extract_to_storage'])
            ->getMockForAbstractClass();

        $packer->expects($this->once())
            ->method('extract_to_storage')
            ->with(
                $this->equalTo($filepath),
                $this->equalTo(42),
                $this->equalTo('component'),
                $this->equalTo('filearea'),
                $this->equalTo('itemid'),
                $this->equalTo('pathbase'),
                $this->equalTo('userid'),
                $this->equalTo(null)
            )
            ->willReturn($expectedresult);

        $result = $fs->extract_to_storage($file, $packer, 42, 'component','filearea', 'itemid', 'pathbase', 'userid');

        $this->assertEquals($expectedresult, $result);
    }

    /**
     * Ensure that the add_storedfile_to_archive function requires a local copy of the
     * file, and passes the path to the archive.
     */
    public function test_add_storedfile_to_archive_directory() {
        $file = $this->get_stored_file('', '.');
        $archivepath = 'example';
        $expectedresult = (object) [];

        // Mock the file_system class.
        $fs = $this->get_testable_mock(['get_local_path_from_storedfile']);
        $fs->method('get_local_path_from_storedfile')
            ->with($this->equalTo($file), $this->equalTo(true))
            ->willReturn(__FILE__);

        $archive = $this->getMockBuilder(file_archive::class)
            ->setMethods([
                'add_directory',
                'add_file_from_pathname',
            ])
            ->getMockForAbstractClass();

        $archive->expects($this->once())
            ->method('add_directory')
            ->with($this->equalTo($archivepath))
            ->willReturn($expectedresult);

        $archive->expects($this->never())
            ->method('add_file_from_pathname');

        $result = $fs->add_storedfile_to_archive($file, $archive, $archivepath);

        $this->assertEquals($expectedresult, $result);
    }

    /**
     * Ensure that the add_storedfile_to_archive function requires a local copy of the
     * file, and passes the path to the archive.
     */
    public function test_add_storedfile_to_archive_file() {
        $file = $this->get_stored_file('example content');
        $filepath = __LINE__;
        $archivepath = 'example';
        $expectedresult = (object) [];

        // Mock the file_system class.
        $fs = $this->get_testable_mock(['get_local_path_from_storedfile']);
        $fs->method('get_local_path_from_storedfile')
            ->with($this->equalTo($file), $this->equalTo(true))
            ->willReturn($filepath);

        $archive = $this->getMockBuilder(file_archive::class)
            ->setMethods([
                'add_directory',
                'add_file_from_pathname',
            ])
            ->getMockForAbstractClass();

        $archive->expects($this->never())
            ->method('add_directory');

        $archive->expects($this->once())
            ->method('add_file_from_pathname')
            ->with(
                $this->equalTo($archivepath),
                $this->equalTo($filepath)
            )
            ->willReturn($expectedresult);

        $result = $fs->add_storedfile_to_archive($file, $archive, $archivepath);

        $this->assertEquals($expectedresult, $result);
    }

    /**
     * Ensure that the add_to_curl_request function requires a local copy of the
     * file, and passes the path to curl_file_create.
     */
    public function test_add_to_curl_request() {
        $file = $this->get_stored_file('example content');
        $filepath = __FILE__;
        $archivepath = 'example';
        $key = 'myfile';

        // Mock the file_system class.
        $fs = $this->get_testable_mock(['get_local_path_from_storedfile']);
        $fs->method('get_local_path_from_storedfile')
            ->with($this->equalTo($file), $this->equalTo(true))
            ->willReturn($filepath);

        $request = (object) ['_tmp_file_post_params' => []];
        $fs->add_to_curl_request($file, $request, $key);
        $this->assertArrayHasKey($key, $request->_tmp_file_post_params);
        $this->assertEquals($filepath, $request->_tmp_file_post_params[$key]->name);
    }

    /**
     * Ensure that test_get_imageinfo_not_image returns false if the file
     * passed was deemed to not be an image.
     */
    public function test_get_imageinfo_not_image() {
        $filecontent = 'example content';
        $file = $this->get_stored_file($filecontent);

        $fs = $this->get_testable_mock([
            'is_image_from_storedfile',
        ]);

        $fs->expects($this->once())
            ->method('is_image_from_storedfile')
            ->with($this->equalTo($file))
            ->willReturn(false);

        $this->assertFalse($fs->get_imageinfo($file));
    }

    /**
     * Ensure that test_get_imageinfo_not_image returns imageinfo.
     */
    public function test_get_imageinfo() {
        $filepath = '/path/to/file';
        $filecontent = 'example content';
        $expectedresult = (object) [];
        $file = $this->get_stored_file($filecontent);

        $fs = $this->get_testable_mock([
            'is_image_from_storedfile',
            'get_local_path_from_storedfile',
            'get_imageinfo_from_path',
        ]);

        $fs->expects($this->once())
            ->method('is_image_from_storedfile')
            ->with($this->equalTo($file))
            ->willReturn(true);

        $fs->expects($this->once())
            ->method('get_local_path_from_storedfile')
            ->with($this->equalTo($file), $this->equalTo(true))
            ->willReturn($filepath);

        $fs->expects($this->once())
            ->method('get_imageinfo_from_path')
            ->with($this->equalTo($filepath))
            ->willReturn($expectedresult);

        $this->assertEquals($expectedresult, $fs->get_imageinfo($file));
    }

    /**
     * Ensure that is_image_from_storedfile always returns false for an
     * empty file size.
     */
    public function test_is_image_empty_filesize() {
        $filecontent = 'example content';
        $file = $this->get_stored_file($filecontent, null, ['get_filesize']);

        $file->expects($this->once())
            ->method('get_filesize')
            ->willReturn(0)
            ;

        $fs = $this->get_testable_mock();
        $this->assertFalse($fs->is_image_from_storedfile($file));
    }

    /**
     * Ensure that is_image_from_storedfile behaves correctly based on
     * mimetype.
     *
     * @dataProvider is_image_from_storedfile_provider
     */
    public function test_is_image_from_storedfile_mimetype($mimetype, $isimage) {
        $filecontent = 'example content';
        $file = $this->get_stored_file($filecontent, null, ['get_mimetype']);

        $file->expects($this->once())
            ->method('get_mimetype')
            ->willReturn($mimetype)
            ;

        $fs = $this->get_testable_mock();
        $this->assertEquals($isimage, $fs->is_image_from_storedfile($file));
    }

    /**
     * Test that get_imageinfo_from_path returns an appropriate response
     * for an image.
     */
    public function test_get_imageinfo_from_path() {
        $filepath = __DIR__ . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR . 'testimage.jpg';

        // Get the filesystem mock.
        $fs = $this->get_testable_mock();

        $method = new ReflectionMethod(file_system::class, 'get_imageinfo_from_path');
        $method->setAccessible(true);
        $result = $method->invokeArgs($fs, [$filepath]);

        $this->assertArrayHasKey('width', $result);
        $this->assertArrayHasKey('height', $result);
        $this->assertArrayHasKey('mimetype', $result);
        $this->assertEquals('image/jpeg', $result['mimetype']);
    }

    /**
     * Test that get_imageinfo_from_path returns an appropriate response
     * for a file which is not an image.
     */
    public function test_get_imageinfo_from_path_no_image() {
        $filepath = __FILE__;

        // Get the filesystem mock.
        $fs = $this->get_testable_mock();

        $method = new ReflectionMethod(file_system::class, 'get_imageinfo_from_path');
        $method->setAccessible(true);
        $result = $method->invokeArgs($fs, [$filepath]);

        $this->assertFalse($result);
    }

    /**
     * Ensure that get_content_file_handle returns a valid file handle.
     */
    public function test_get_content_file_handle_default() {
        $filecontent = 'example content';
        $file = $this->get_stored_file($filecontent);

        $fs = $this->get_testable_mock(['get_remote_path_from_storedfile']);
        $fs->method('get_remote_path_from_storedfile')
            ->willReturn(__FILE__);

        // Note: We are unable to determine the mode in which the $fh was opened.
        $fh = $fs->get_content_file_handle($file);
        $this->assertTrue(is_resource($fh));
        $this->assertEquals('stream', get_resource_type($fh));
        fclose($fh);
    }

    /**
     * Ensure that get_content_file_handle returns a valid file handle for a gz file.
     */
    public function test_get_content_file_handle_gz() {
        $filecontent = 'example content';
        $file = $this->get_stored_file($filecontent);

        $fs = $this->get_testable_mock(['get_remote_path_from_storedfile']);
        $fs->method('get_remote_path_from_storedfile')
            ->willReturn(__DIR__ . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR . 'test.tgz');

        // Note: We are unable to determine the mode in which the $fh was opened.
        $fh = $fs->get_content_file_handle($file, stored_file::FILE_HANDLE_GZOPEN);
        $this->assertTrue(is_resource($fh));
        gzclose($fh);
    }

    /**
     * Ensure that get_content_file_handle returns an exception when calling for a invalid file handle type.
     */
    public function test_get_content_file_handle_invalid() {
        $filecontent = 'example content';
        $file = $this->get_stored_file($filecontent);

        $fs = $this->get_testable_mock(['get_remote_path_from_storedfile']);
        $fs->method('get_remote_path_from_storedfile')
            ->willReturn(__FILE__);

        $this->expectException('coding_exception', 'Unexpected file handle type');
        $fs->get_content_file_handle($file, -1);
    }

    /**
     * Ensure that deleted_file_cleanup does nothing with an empty file.
     */
    public function test_deleted_file_cleanup_empty() {
        $this->resetAfterTest();
        global $DB;

        $DB = $this->getMockBuilder(\moodle_database::class)
            ->setMethods(['record_exists'])
            ->getMockForAbstractClass();

        $DB->expects($this->never())
            ->method('record_exists');

        $fs = $this->get_testable_mock(['remove_file']);
        $fs->expects($this->never())
            ->method('remove_file');

        $result = $fs->deleted_file_cleanup(sha1(''));
        $this->assertNull($result);
    }

    /**
     * Ensure that deleted_file_cleanup does nothing when a file is still
     * in use.
     */
    public function test_deleted_file_cleanup_in_use() {
        $this->resetAfterTest();
        global $DB;

        $DB = $this->getMockBuilder(\moodle_database::class)
            ->setMethods(['record_exists'])
            ->getMockForAbstractClass();

        $DB->method('record_exists')->willReturn(true);

        $fs = $this->get_testable_mock(['remove_file']);
        $fs->expects($this->never())
            ->method('remove_file');
        $result = $fs->deleted_file_cleanup('example hash');
        $this->assertNull($result);
    }

    /**
     * Ensure that deleted_file_cleanup removes the file when it is no
     * longer in use.
     */
    public function test_deleted_file_cleanup_expired() {
        $this->resetAfterTest();
        global $DB;

        $DB = $this->getMockBuilder(\moodle_database::class)
            ->setMethods(['record_exists'])
            ->getMockForAbstractClass();

        $DB->method('record_exists')->willReturn(false);

        $fs = $this->get_testable_mock(['remove_file']);
        $fs->expects($this->once())
            ->method('remove_file');
        $fs->deleted_file_cleanup('example hash');
    }

    /**
     * Test that mimetype_from_file returns appropriate output when the
     * file could not be found.
     */
    public function test_mimetype_not_found() {
        $mimetype = file_system::mimetype('/path/to/nonexistent/file');
        $this->assertEquals('document/unknown', $mimetype);
    }

    /**
     * Test that mimetype_from_file returns appropriate output for a known
     * file.
     *
     * Note: this is not intended to check that functions outside of this
     * file works. It is intended to validate the codepath contains no
     * errors and behaves as expected.
     */
    public function test_mimetype_known() {
        $mimetype = file_system::mimetype_from_file(__DIR__ . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR . 'testimage.jpg');
        $this->assertEquals('image/jpeg', $mimetype);
    }

    /**
     * Test that mimetype_from_file returns appropriate output when the
     * file could not be found.
     */
    public function test_mimetype_from_file_not_found() {
        $mimetype = file_system::mimetype_from_file('/path/to/nonexistent/file');
        $this->assertEquals('document/unknown', $mimetype);
    }

    /**
     * Test that mimetype_from_file returns appropriate output for a known
     * file.
     *
     * Note: this is not intended to check that functions outside of this
     * file works. It is intended to validate the codepath contains no
     * errors and behaves as expected.
     */
    public function test_mimetype_from_file_known() {
        $mimetype = file_system::mimetype_from_file(__DIR__ . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR . 'testimage.jpg');
        $this->assertEquals('image/jpeg', $mimetype);
    }

    /**
     * Test that mimetype_from_hash returns the correct mimetype with
     * a file whose filename suggests mimetype.
     */
    public function test_mimetype_from_hash_using_filename() {
        $filepath = '/path/to/file/not/currently/on/disk';
        $filecontent = 'example content';
        $filename = 'test.jpg';
        $contenthash = sha1($filecontent);

        $fs = $this->get_testable_mock(['get_remote_path_from_hash']);
        $fs->method('get_remote_path_from_hash')->willReturn($filepath);

        $result = $fs->mimetype_from_hash($contenthash, $filename);
        $this->assertEquals('image/jpeg', $result);
    }

    /**
     * Test that mimetype_from_hash returns the correct mimetype with
     * a locally available file whose filename does not suggest mimetype.
     */
    public function test_mimetype_from_hash_using_file_content() {
        $filepath = '/path/to/file/not/currently/on/disk';
        $filecontent = 'example content';
        $contenthash = sha1($filecontent);
        $filename = 'example';

        $filepath = __DIR__ . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR . 'testimage.jpg';
        $fs = $this->get_testable_mock(['get_remote_path_from_hash']);
        $fs->method('get_remote_path_from_hash')->willReturn($filepath);

        $result = $fs->mimetype_from_hash($contenthash, $filename);
        $this->assertEquals('image/jpeg', $result);
    }

    /**
     * Test that mimetype_from_hash returns the correct mimetype with
     * a remotely available file whose filename does not suggest mimetype.
     */
    public function test_mimetype_from_hash_using_file_content_remote() {
        $filepath = '/path/to/file/not/currently/on/disk';
        $filecontent = 'example content';
        $contenthash = sha1($filecontent);
        $filename = 'example';

        $filepath = __DIR__ . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR . 'testimage.jpg';

        $fs = $this->get_testable_mock([
            'get_remote_path_from_hash',
            'is_readable_locally_by_hash',
            'get_local_path_from_hash',
        ]);

        $fs->method('get_remote_path_from_hash')->willReturn('/path/to/remote/file');
        $fs->method('is_readable_locally_by_hash')->willReturn(false);
        $fs->method('get_local_path_from_hash')->willReturn($filepath);

        $result = $fs->mimetype_from_hash($contenthash, $filename);
        $this->assertEquals('image/jpeg', $result);
    }

    /**
     * Test that mimetype_from_storedfile returns the correct mimetype with
     * a file whose filename suggests mimetype.
     */
    public function test_mimetype_from_storedfile_using_filename() {
        $filepath = '/path/to/file/not/currently/on/disk';
        $fs = $this->get_testable_mock(['get_remote_path_from_storedfile']);
        $fs->method('get_remote_path_from_storedfile')->willReturn($filepath);

        $file = $this->get_stored_file('example content', 'test.jpg');

        $result = $fs->mimetype_from_storedfile($file);
        $this->assertEquals('image/jpeg', $result);
    }

    /**
     * Test that mimetype_from_storedfile returns the correct mimetype with
     * a locally available file whose filename does not suggest mimetype.
     */
    public function test_mimetype_from_storedfile_using_file_content() {
        $filepath = __DIR__ . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR . 'testimage.jpg';
        $fs = $this->get_testable_mock(['get_remote_path_from_storedfile']);
        $fs->method('get_remote_path_from_storedfile')->willReturn($filepath);

        $file = $this->get_stored_file('example content');

        $result = $fs->mimetype_from_storedfile($file);
        $this->assertEquals('image/jpeg', $result);
    }

    /**
     * Test that mimetype_from_storedfile returns the correct mimetype with
     * a remotely available file whose filename does not suggest mimetype.
     */
    public function test_mimetype_from_storedfile_using_file_content_remote() {
        $filepath = __DIR__ . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR . 'testimage.jpg';

        $fs = $this->get_testable_mock([
            'get_remote_path_from_storedfile',
            'is_readable_locally_by_storedfile',
            'get_local_path_from_storedfile',
        ]);

        $fs->method('get_remote_path_from_storedfile')->willReturn('/path/to/remote/file');
        $fs->method('is_readable_locally_by_storedfile')->willReturn(false);
        $fs->method('get_local_path_from_storedfile')->willReturn($filepath);

        $file = $this->get_stored_file('example content');

        $result = $fs->mimetype_from_storedfile($file);
        $this->assertEquals('image/jpeg', $result);
    }

    /**
     * Data Provider for is_image_from_storedfile tests.
     *
     * @return array
     */
    public function is_image_from_storedfile_provider() {
        return array(
            'Standard image'            => array('image/png', true),
            'Made up document/image'    => array('document/image', false),
        );
    }

    /**
     * Data provider for get_local_path_from_storedfile tests.
     *
     * @return array
     */
    public function get_local_path_from_storedfile_provider() {
        return [
            'default args (nofetch)' => [
                'args' => [],
                'fetch' => 0,
            ],
            'explicit: nofetch' => [
                'args' => [false],
                'fetch' => 0,
            ],
            'explicit: fetch' => [
                'args' => [true],
                'fetch' => 1,
            ],
        ];
    }
}
