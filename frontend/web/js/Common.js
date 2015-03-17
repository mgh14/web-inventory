/**
 * JavaScript for all common functionality throughout the website
 */

/**
 *
 * @param gridViewBtnSelector
 * @param listViewBtnSelector
 * @param gridContainerSelector
 * @param listContainerSelector
 */

function setUpGridAndListView(gridViewBtnSelector, listViewBtnSelector,
    gridContainerSelector, listContainerSelector) {

    // set up 'grid' and 'list' views
    $(gridViewBtnSelector).click(function() {
        $(gridContainerSelector).show();
        $(listContainerSelector).hide();
    });

    $(listViewBtnSelector).click(function() {
        $(gridContainerSelector).hide();
        $(listContainerSelector).show();
    })
}
