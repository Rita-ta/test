(function($) {

    'use strict';

    var $window = $( window ),
        $body = $( 'body' );

    $window.ready(function() {
        postLoader();
    });

    function postLoader() {

        var container = $( '.posts-container' ),
            postsContainer = container.find( '.posts' ),
            postCategoriesLinks = container.find( '.post-filter-cat' ),
            postTargetLinks = container.find( '.post-filter-target' ),
            postSortLinks = container.find( '.post-filter-sort' );

        container.on( 'click', '.post-filter-cat a', function( e )  {
            e.preventDefault();

            var currentTermId = $( this ).attr( 'data-term-id' ),
                postTarget = postTargetLinks.find( '.active' ).children( 'a' ).attr( 'data-target' ),
                postSort = postSortLinks.find( '.active' ).children( 'a' ).attr( 'data-sort' );

            $( this ).parent( 'li' ).siblings().removeClass('active');
            $( this ).parent( 'li' ).addClass( 'active' );

            var data = {
                action: 'add_posts',
                termid: currentTermId,
                target: postTarget,
                sort: postSort
            };

            $.post( testAjax.url, data, function( response ) {
                postsContainer.html( response );
            });
        });

        container.on( 'click', '.post-filter-target a', function( e )  {
            e.preventDefault();

            var currentTermId = postCategoriesLinks.find( '.active' ).children( 'a' ).attr( 'data-term-id' ),
                postTarget = $( this ).attr( 'data-target' ),
                postSort = postSortLinks.find( '.active' ).children( 'a' ).attr( 'data-sort' );

            $( this ).parent( 'li' ).siblings().removeClass('active');
            $( this ).parent( 'li' ).addClass( 'active' );

            var data = {
                action: 'add_posts',
                termid: currentTermId,
                target: postTarget,
                sort: postSort
            };

            $.post( testAjax.url, data, function( response ) {
                postsContainer.html( response );
            });
        });

        container.on( 'click', '.post-filter-sort a', function( e )  {
            e.preventDefault();

            var currentTermId = postCategoriesLinks.find( '.active' ).children( 'a' ).attr( 'data-term-id' ),
                postTarget = postTargetLinks.find( '.active' ).children( 'a' ).attr( 'data-target' ),
                postSort = $( this ).attr( 'data-sort' );

            $( this ).parent( 'li' ).siblings().removeClass('active');
            $( this ).parent( 'li' ).addClass( 'active' );

            var data = {
                action: 'add_posts',
                termid: currentTermId,
                target: postTarget,
                sort: postSort
            };

            $.post( testAjax.url, data, function( response ) {
                postsContainer.html( response );
            });
        });

    }

}(jQuery));