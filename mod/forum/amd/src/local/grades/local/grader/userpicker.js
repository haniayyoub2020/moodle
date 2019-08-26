import Templates from 'core/templates';
import Selectors from './userpicker/selectors';

const init = (items, index) => { // eslint-disable-line
    // TODO generate the full name from PHP function.

    return {
        firstName: items[index].firstname,
        lastName: items[index].lastname,
        displayindex: index + 1,
        total: items.length,
    };
};

const renderNavigator = (context) => {
    return Templates.render('mod_forum/local/grades/local/grader/userpicker', context);
};

const renderUserChange = (context) => {
    return Templates.render('mod_forum/local/grades/local/grader/userpicker/detail', context);
};

const _cacheDom = (html) => { // eslint-disable-line
    let widget = document.createElement('div');
    widget.innerHTML = html;
    let paginator = widget.querySelector('[data-grader="paginator"]');
    let nextButton = paginator.querySelector('[data-action="next-user"]');
    let previousButton = paginator.querySelector('[data-action="previous-user"]');
    return [nextButton, previousButton];
};

// Use the next index or the given index here.
const nextUser = async(items, index) => {
    index++;

    items[index].displayIndex = index++;

    let [html, js] = await Promise.all([renderUserChange(items[index])]);
    Templates.replaceNodeContents(Selectors.regions.userDetail, html, js);

    // PubSub
};

const previousUser = async(items, index) => {
    index--;

    items[index].displayIndex = index++;

    let [html, js] = await Promise.all([renderUserChange(items[index])]);
    Templates.replaceNodeContents(Selectors.regions.userDetail, html, js);

    // PubSub
};

const bindEvents = (nextButton, previousButton, items, index) => { //eslint-disable-line
    nextButton.addEventListener('click', function() {
        nextUser(items, index);
    });
    previousButton.addEventListener('click', function() {
        previousUser(items, index);
    });
};

export default async(userList, currentUser, showUserCallback) => { // eslint-disable-line
    const [{html, js}] = await Promise.all([
        renderNavigator(currentUser).then((html, js) => {
            return {html, js};
        })]
    );

    // TODO let [nextButton, previousButton] = _cacheDom(html);

    // TODO bindEvents(nextButton, previousButton, items, index);

    return {html, js};
};
