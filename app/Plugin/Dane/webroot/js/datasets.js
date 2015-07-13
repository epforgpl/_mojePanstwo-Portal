$(document).ready(function () {
    var options = {
            valueNames: ['title', 'desc', 'hidden']
        },
        $hackerList = $('#hacker-list'),
        hackerList = new List('hacker-list', options);

    $('.searchInput .search').focus();

    $hackerList.find('.searchInput').submit(function (event) {
        event.preventDefault();
    });
});