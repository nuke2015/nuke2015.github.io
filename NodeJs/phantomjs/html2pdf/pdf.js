var phantom = require('phantom');   

phantom.create().then(function(ph) {
    ph.createPage().then(function(page) {
        page.open("https://m.sohu.com/").then(function(status) {
            page.render('sohu.pdf').then(function() {
                console.log('Page Rendered');
                ph.exit();
            });
        });
    });
});