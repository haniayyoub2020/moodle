import Templates from 'core/templates';
import {exception as notifyException} from 'core/notification';
import LoadingIcon from 'core/loadingicon';

const templateNames = {
    // TODO move this to subfolder once MDL-50346 lands.
    window: 'core/fullscreen',
};

const getHelpers = (windowNode) => {
    const getBody = () => {
        return windowNode.firstElementChild;
    };

    const remove = () => {
        windowNode.remove();
    };

    return {
        windowNode,
        getBody,
        remove,
    };
};

const getFullScreenWindow = () => {
    const windowNode = document.createElement('div');
    windowNode.classList.add('fullscreen');
    LoadingIcon.addIconToContainer(windowNode);
    document.body.append(windowNode);

    return new Promise((resolve) => {
        Templates.render(templateNames.window, {})
        .then((html, js) => {
            return Templates.appendNodeContents(windowNode, html, js);
        })
        .then(() => {
            return resolve(windowNode);
        })
        .catch(notifyException);
    });
};

/**
 * @param {Object} configuration
 * @returns {Object} Functions
 */
export default async function() {
    const window = await getFullScreenWindow();

    return getHelpers(window);
}
