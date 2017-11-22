(function() {
    tinymce.create('tinymce.plugins.interview_buttons', {
        init : function(ed, url) {



        	ed.addButton('question', {
                title : 'Question',
                cmd : 'question',
                image : url + '/../images/question.png'
            });

            ed.addCommand('question', function() {
                var selected_text = ed.selection.getContent();
                var return_text = '';
                return_text = '[question]' + selected_text + '[/question]';
                ed.execCommand('mceInsertContent', 0, return_text);
            });




            ed.addButton('answer', {
                title : 'Answer',
                cmd : 'answer',
                image : url + '/../images/answer.png'
            });

            ed.addCommand('answer', function() {
                var selected_text = ed.selection.getContent();
                var return_text = '';
                return_text = '[answer]' + selected_text + '[/answer]';
                ed.execCommand('mceInsertContent', 0, return_text);
            });




        },
        // ... Hidden code
    });
    // Register plugin
    tinymce.PluginManager.add( 'interview_buttons', tinymce.plugins.interview_buttons );
})();