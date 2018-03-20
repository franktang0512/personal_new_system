$(document).ready(function(){
    $(".slide").click(function(e){
        $(this).siblings(".submenu").slideToggle(300);
    });
    $(".trigger").click(function(){
       var id=$(this).attr("id");
       switch(id){
        case "tax_rpt_1":
        $.ajax({data:"ajax=true",url:"gen_tax_rpt_1.php"});
        break;
        case "tax_rpt_2":
        $.ajax({data:"ajax=true",url:"gen_tax_rpt_2.php"});
        break;
        case "tax_rpt_3":
        $.ajax({data:"ajax=true",url:"gen_tax_rpt_3.php"});
        break;
        case "salary_rpt_1":
        $.ajax({data:"ajax=true",url:"gen_salary_rpt_1.php"});
        break;
        case "salary_rpt_21":
        $.ajax({data:"ajax=true",url:"gen_salary_rpt_21.php"});
        break;
        case "salary_rpt_22":
        $.ajax({data:"ajax=true",url:"gen_salary_rpt_22.php"});
        break;
        case "salary_rpt_23":
        $.ajax({data:"ajax=true",url:"gen_salary_rpt_23.php"});
        break;
        case "gen_hours_rpt":
        $.ajax({data:"ajax=true",url:"gen_hours_rpt.php"});
        break;
        case "salary_rpt_12":
        $.ajax({data:"ajax=true",url:"gen_salary_rpt_12.php"});
        break;
        case "salary_rpt_13":
        $.ajax({data:"ajax=true",url:"gen_salary_rpt_13.php"});
        break;
        case "salary_rpt_14":
        $.ajax({data:"ajax=true",url:"gen_salary_rpt_14.php"});
        break;
        case "salary_rpt_15":
        $.ajax({data:"ajax=true",url:"gen_salary_rpt_15.php"});
        break;
       }
    });
    $.ajaxSetup({
        type:"GET",
        cache:false,
        dataType:"html",
        beforeSend:function(){
         $(".loading").show(); 
         $("#content").hide();
        },
        complete:function(){
         $(".loading").hide();  
         $("#content").fadeIn(600);
        },
        success:function(data){
        $("#content").html(data);    
        },
        error:function(xhr,aa){
        $("#content").html("<div>資料要求發生錯誤!</div>");     
        }
    });
});
