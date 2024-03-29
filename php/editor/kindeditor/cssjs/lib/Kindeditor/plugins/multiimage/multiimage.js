KindEditor.plugin('multiimage', function(K) {
    var self = this,
        name = 'multiimage',
        lang = self.lang(name + '.'),
        fileManagerJson = K.undef(self.fileManagerJson, false),
        editorid = self.editorid;
    self.clickToolbar(name, function() {
        var html = ['<div class="ke-map" style="width:600px;height:420px;"></div>'].join('');
        var dialog = self.createDialog({
            name: name,
            width: 600,
            height: 440,
            title: self.lang(name),
            body: html,
            yesBtn: {
                name: self.lang('yes'),
                click: function(e) {
                    imgdata = '';
                    datadiv = K('.res_item img', doc);
                    datadiv.each(function(k, v) {
                        imgdata += '<img src="' + $(v).attr('src') + '" />';
                    });
                    self.insertHtml(imgdata).hideDialog().focus();
                }
            }
        });
        var div = dialog.div,
            win, doc;
        var iframe = K('<iframe class="ke-textarea" frameborder="0" src="' + fileManagerJson + '" style="width:600px;height:440px;border:none;"></iframe>');

        function ready() {
            win = iframe[0].contentWindow;
            doc = K.iframeDoc(iframe);
        }
        iframe.bind('load', function() {
            iframe.unbind('load');
            if (K.IE) {
                ready();
            } else {
                setTimeout(ready, 0);
            }
        });
        K('.ke-map', div).replaceWith(iframe);
    });
});