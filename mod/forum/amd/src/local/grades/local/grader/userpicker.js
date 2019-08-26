import Templates from 'core/templates';
import Selectors from './userpicker/selectors';

const init = (items, index) => {
    // TODO generate the full name from PHP function.

    return {
        firstName: items[index].firstname,
        lastName: items[index].lastname,
        displayindex: index + 1,
        total: items.length,
    };
};

const renderNavigator = (context) => {
    return Templates.render('mod_forum/local/grades/unified_grader/user_navigator', context);
};

const renderUserChange = (context) => {
    return Templates.render('mod_forum/local/grades/unified_grader/user_navigator_user', context);
};

const _cacheDom = (html) => {
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

const bindEvents = (nextButton, previousButton, items, index) => {
    nextButton.addEventListener('click', function() {
        nextUser(items, index);
    });
    previousButton.addEventListener('click', function() {
        previousUser(items, index);
    });
};

export const buildPicker = async(items, index) => {
    // TODO
    let context = init(items, index);

    let [html, js] = await Promise.all([renderNavigator(context)]);

    let [nextButton, previousButton] = _cacheDom(html);

    bindEvents(nextButton, previousButton, items, index);

    return [html, js];
};
