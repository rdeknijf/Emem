(function(document, window, undefined){

//    function Project(node_link) {
//
//        // nodes and vars
//
//        this.node_link = $(node_link);
//        this.id = parseInt(node_link.id.substr(9));
//        this.node_art = $(Emem.node_stage).children('#art_pid_' + this.id);
//        this.node_home = $(Emem.node_home).children('img#homelink_pid_' + this.id);
//
//
//
//        return this;
//
//    }

    Emem = {
        node_home : undefined,
        node_stage : undefined,
        node_nav : undefined,
        projects : new Array,
        onReady : function(){

            Emem.node_home = $("section#home");
            Emem.node_stage = $("div#stage");
            Emem.node_nav = $('#projectlisting');

            $('.link_portfolio').click(function(event){
                event.preventDefault();
                $.scrollTo('#portfolio', 500, {
                    offset: -100
                });
            });

            $('.link_about').click(function(event){
                event.preventDefault();
                $.scrollTo('#about', 500,{
                    offset: -100
                });
            });

            $('.link_contact').click(function(event){
                event.preventDefault();
                $.scrollTo('max', 500);
            });

            $(Emem.node_nav).click(function(event){

                Emem.toggle($(event.target).closest('a').attr('id').substr(9));

            });

            $(Emem.node_home).click(function(event){

               $('.link_portfolio').click();
               Emem.toggle($(event.target).attr('id').substr(13));

            });




            $(Emem.node_nav).children('ul').children('li:first-child').children('a.project_link').click();




        },
        toggle : function(id) {

            $(Emem.node_stage).children().fadeOut('fast').promise().done(function(){
                $(Emem.node_stage).children('#art_pid_' + id).fadeIn('fast');
            });

            $(Emem.node_nav).find('a.project_link').removeClass('active');
            $(Emem.node_nav).find('a#link_pid_'+id).addClass('active');

            $(Emem.node_home).children().removeClass('active');
            $(Emem.node_home).children('img#homelink_pid_' + id).addClass('active');

        }
    }

    $(document).ready(function(){

        Emem.onReady();

        $(window).sausage({
            page : '.sausage-page-selector',
            content: function (i, $page) {
                console.log($($page).attr('name'));
                return '<span class="sausage-span">' + $($page).attr('name') + '</span>';
            }
        });

        $("a.photo_thumb").prettyPhoto();

    });




}(document, window));