<!DOCTYPE html>
<html>
<head>
    <style>
        .center {

            display: inline-block;
            top: 10%;
            left: 50%;
        }
        /** Custom Select **/
        
        .custom-select-wrapper {
            position: relative;
            display: inline-block;
            user-select: none;
        }
        
        .custom-select-wrapper select {
            display: none;
        }
        
        .custom-select {
            position: relative;
            display: inline-block;
        }
        
        .custom-select-trigger {
            position: relative;
            display: block;
            width: 130px;
            padding: 0 84px 0 22px;
            font-size: 22px;
            font-weight: 300;
            color: #fff;
            line-height: 60px;
            background: #5c9cd8;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .custom-select-trigger:after {
            position: absolute;
            display: block;
            content: '';
            width: 10px;
            height: 10px;
            top: 50%;
            right: 25px;
            margin-top: -3px;
            border-bottom: 1px solid #fff;
            border-right: 1px solid #fff;
            transform: rotate(45deg) translateY(-50%);
            transition: all .4s ease-in-out;
            transform-origin: 50% 0;
        }
        
        .custom-select.opened .custom-select-trigger:after {
            margin-top: 3px;
            transform: rotate(-135deg) translateY(-50%);
        }
        
        .custom-options {
            position: absolute;
            display: block;
            top: 100%;
            left: 0;
            right: 0;
            min-width: 100%;
            margin: 15px 0;
            border: 1px solid #b5b5b5;
            border-radius: 4px;
            box-sizing: border-box;
            box-shadow: 0 2px 1px rgba(0, 0, 0, .07);
            background: #fff;
            transition: all .4s ease-in-out;
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transform: translateY(-15px);
        }
        
        .custom-select.opened .custom-options {
            opacity: 1;
            visibility: visible;
            pointer-events: all;
            transform: translateY(0);
        }
        
        .custom-options:before {
            position: absolute;
            display: block;
            content: '';
            bottom: 100%;
            right: 25px;
            width: 7px;
            height: 7px;
            margin-bottom: -4px;
            border-top: 1px solid #b5b5b5;
            border-left: 1px solid #b5b5b5;
            background: #fff;
            transform: rotate(45deg);
            transition: all .4s ease-in-out;
        }
        
        .option-hover:before {
            background: #f9f9f9;
        }
        
        .custom-option {
            position: relative;
            display: block;
            padding: 0 22px;
            border-bottom: 1px solid #b5b5b5;
            font-size: 18px;
            font-weight: 600;
            color: #b5b5b5;
            line-height: 47px;
            cursor: pointer;
            transition: all .4s ease-in-out;
        }
        
        .custom-option:first-of-type {
            border-radius: 4px 4px 0 0;
        }
        
        .custom-option:last-of-type {
            border-bottom: 0;
            border-radius: 0 0 4px 4px;
        }
        
        .custom-option:hover,
        .custom-option.selection {
            background: #f9f9f9;
        }
    </style>	
</head>

<body>
    <div class="center">
        <select class="custom-select" placeholder="Source Type">
            <option value="profile">Profile</option>
            <option value="word">Word</option>
            <option value="hashtag">Hashtag</option>
        </select>
    </div>
	
	
	<script src='./js/jquerylist.js'></script>

    <script>
        $(".custom-select").each(function() {
            var classes = $(this).attr("class"),
                id = $(this).attr("id"),
                name = $(this).attr("name");
            var template = '<div class="' + classes + '">';
            template += '<span class="custom-select-trigger">' + $(this).attr("placeholder") + '</span>';
            template += '<div class="custom-options">';
            $(this).find("option").each(function() {
                template += '<span class="custom-option ' + $(this).attr("class") + '" data-value="' + $(this).attr("value") + '">' + $(this).html() + '</span>';
            });
            template += '</div></div>';

            $(this).wrap('<div class="custom-select-wrapper"></div>');
            $(this).hide();
            $(this).after(template);
        });
        $(".custom-option:first-of-type").hover(function() {
            $(this).parents(".custom-options").addClass("option-hover");
        }, function() {
            $(this).parents(".custom-options").removeClass("option-hover");
        });
        $(".custom-select-trigger").on("click", function() {
            $('html').one('click', function() {
                $(".custom-select").removeClass("opened");
            });
            $(this).parents(".custom-select").toggleClass("opened");
            event.stopPropagation();
        });
        $(".custom-option").on("click", function() {
            $(this).parents(".custom-select-wrapper").find("select").val($(this).data("value"));
            $(this).parents(".custom-options").find(".custom-option").removeClass("selection");
            $(this).addClass("selection");
            $(this).parents(".custom-select").removeClass("opened");
            $(this).parents(".custom-select").find(".custom-select-trigger").text($(this).text());
        });
    </script>
</body>
</html>