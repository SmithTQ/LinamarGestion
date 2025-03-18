$(document).ready(function(){

    /* MODAL */

    $(".btn-modal").on('click', function(e){
        let idModal = $(this).attr('data-id-modal');
        $(idModal).toggleClass('show');
    });
    
    $(".btn-dismiss-modal").on('click', function(e){
        let idModal = '#' + $(this).closest('.modal').attr('id');
        $(idModal).toggleClass('show');
    });

    window.addEventListener("click", function(e){
        if(e.target.id.includes("modal")){
            $(".modal").removeClass("show");
        }
    });

    /* END MODAL */

    /* ASIDE */

    $('.btn-toggle-aside').on('click', function (e) {
        $('aside').toggleClass('open');
    });

    /* END ASIDE */
});