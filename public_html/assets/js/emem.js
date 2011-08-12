(function(document, window, undefined){

    function Project(node_link) {

        // nodes and vars

        this.node_link = $(node_link);
        this.id = parseInt(node_link.id.substr(9));
        this.node_art = $(Emem.node_stage).children('#art_pid_' + this.id);
        this.node_home = $(Emem.node_home).children('img#homelink_pid_' + this.id);



        return this;

    }

    Emem = {
        node_home : undefined,
        node_stage : undefined,
        node_nav : undefined,
        projects : new Array,
        onReady : function(){

            Emem.node_home = $("section#home");
            Emem.node_stage = $("div#stage");
            Emem.node_nav = $('#projectlisting');



//            var nodes = $('#projectlisting').find('a.project_link');
//
//            $(nodes).each(function(key, node_link){
//
//                Emem.projects.push(new Project(node_link));
//
//            });
            $(Emem.node_nav).click(function(pass){

                //console.log($(pass.target).closest('a').attr('id'));

                Emem.toggle($(pass.target).closest('a').attr('id').substr(9));

            });

            $(Emem.node_home).click(function(pass){

               Emem.toggle($(pass.target).attr('id').substr(13));

            });



        },
        toggle : function(id) {

            //console.log(id);

            $(Emem.node_stage).children().hide();
            $(Emem.node_stage).children('#art_pid_' + id).show();

            $(Emem.node_nav).find('a.project_link').removeClass('active');
            $(Emem.node_nav).find('a#link_pid_'+id).addClass('active');

            $(Emem.node_home).children().removeClass('active');
            $(Emem.node_home).children('img#homelink_pid_' + id).addClass('active');

        }
    }

    $(document).ready(function(){

        Emem.onReady();

    });

}(document, window));