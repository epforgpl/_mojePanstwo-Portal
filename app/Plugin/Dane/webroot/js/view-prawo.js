$(document).ready(function () {
    var timeline_data = [
        {
            type: 'blog_post',
            date: '2011-08-03',
            dateFormat: 'DD MMMM YYYY',
            title: 'Blog Post',
            content: '',
            image: 'xxxx.jpg',
            readmore: 'http://www.example.com'
        },
        {
            type: 'slider',
            date: '2011-08-01',
            dateFormat: 'DD MMMM YYYY',
            height: 200,
            images: ['xxx.jpg', 'xxx.jpg'],
            speed: 5000
        }
    ];

    var timeline = new Timeline($('#timeline'), timeline_data);
    timeline.display();
});