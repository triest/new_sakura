/* WOW ANIMATION ============ */
var wow_animation = function () {
    if ($('.wow').length > 0) {
        var wow = new WOW(
            {
                boxClass: 'wow',      // animated element css class (default is wow)
                animateClass: 'animated', // animation css class (default is animated)
                offset: 50,          // distance to the element when triggering the animation (default is 0)
                mobile: false       // trigger animations on mobile devices (true is default)
            });
        wow.init();
    }
}
wow_animation();


function initHeader() {
    $('header.header').each(function () {
        var hold = $(this);
        var search = hold.find('.toggle-search, .search-close');
        var menu = hold.find('.toggle-menu');
        var searchClass = 'open-search';
        var menuClass = 'open-menu';
        var searchInput = hold.find('input.search-input');
        search.click(function () {
            if (hold.hasClass(searchClass)) {
                hold.removeClass(searchClass);
            } else {
                hold.addClass(searchClass);
                searchInput.focus();
                hold.removeClass(menuClass);
            }
        });
        menu.click(function () {
            hold.toggleClass(menuClass);
        });
    });

}

$(document).ready(function () {
    $(document).on('focus blur input', '.group_input input', function () {
        $('.group_input input').each(function () {
            var el = $(this).parent();
            if ($(this).is(":focus")) {
                $(el).addClass('is_focus');
            } else {
                $(el).removeClass('is_focus');
            }
        });
    });
});


$(document).ready(function () {
    $(document).on('focus blur input', '.lk-group-input input', function () {
        $('.lk-group-input input').each(function () {
            var el = $(this).parent();
            if ($(this).is(":focus")) {
                $(el).addClass('is_focus');
            } else {
                $(el).removeClass('is_focus');
            }
        });
    });
});

$(document).ready(function () {

    initHeader();




    if (window.location.hash) {
        if ($(window.location.hash + '.program_course').length) {
            $(window.location.hash + '.program_course .txt').addClass('open');

            setTimeout(function () {
                let top = $(window.location.hash + '.program_course').offset().top;
                $('html, body').scrollTop(top - 20);
            }, 500);


        }
    }

    $(".program_course .title").click(function () {

        let pc = $(this).closest('.program_course');
        let el = $(".txt", pc);

        if (el.hasClass('open')) {
            el.removeClass('open');
            pc.removeClass('active');
        } else {
            $("p", pc).removeClass('open');
            el.addClass('open');
            pc.addClass('active');
        }

        el = $(".close", $(this).closest('.program_course'));
        if (el.hasClass('active')) {
            el.removeClass('active');
        } else {
            el.addClass('active');
        }


    });

})

$(document).ready(function () {

    $(document).on('click', ".nice-select.wide", function () {
        $('.nice-select.wide').not(this).removeClass('open');

        if ($(this).hasClass('open')) {
            $(this).removeClass('open');
        } else {
            $(this).addClass('open');
        }
    }).on("click", function (event) {
        if (!$(event.target).closest(".nice-select.wide").length) {
            $(".nice-select.wide").removeClass('open');
        }
    });


// tabs
    (function($) {
        $(function() {
            $("ul.tabs__caption").on("click", "li:not(.active)", function() {
                $(this)
                    .addClass("active")
                    .siblings()
                    .removeClass("active")
                    .closest("div.tabs")
                    .find("div.tabs__content")
                    .removeClass("active")
                    .eq($(this).index())
                    .addClass("active");
            });
        });
    })(jQuery);

    $(".lk-profile").on('click', function () {
        "opened" == $(this).attr("status") ? $(this).attr("status", "closed").find(".lk-profile__menu").slideUp(200) : $(this).attr("status", "opened").find(".lk-profile__menu").slideDown(200)
    })

});