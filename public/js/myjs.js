$(document).ready(function(){
    //check page already there if not get its templates
    $("select[name='page_for']").change(function(){
       var page= $("select[name='page_for']").val();
       var site_id= $("select[name='site_id']").val();
       if(site_id==0 || site_id==null){
        $("select[name='page_for']").val('blank');
        alert('You must select site id before proceed further');
        return false;
       }
       if(page != "blank"){
       	$.ajax({
       		url: ajaxhandler,
       		headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
       		type: 'POST',
       		data: {
            "page_for": page,
            "need": "get_page_templates",
            "site_id" : site_id
            },
       		success: function(result){
            if(result=='page_exists'){
              $("select[name='page_for']").val('blank');
              alert('The page already exists for this site');
              return false;
            }
       		  data=JSON.parse(result);
            $('#page_template_id').find('select').empty();
            $('#page_template_id').find('select').append($('<option value="blank"></option>'));
            $('#page_template_id').show();
            $.each(data, function(i, value) {
			      $('#page_template_id').find('select').append($('<option>').text(value).attr('value', value));
			       });
            }
       	});
       }else{
       	alert('please select the page');
       }
    });
      //select modules
       $("select[name='page_template']").change(function(){
       var template= $("select[name='page_template']").val();
       if(typeof $("input[name='page_for']").val() !== "undefined"){
        var page_for= $("input[name='page_for']").val();
       }else{
       var page_for= $("select[name='page_for']").val(); 
       }
       if(template){
        $.ajax({
          url: ajaxhandler,
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
          type: 'POST',
          data: {
            "need": "get_template_modules",
            "template": template,
            "page_for": page_for
            },
          success: function(result){
            if(result==null){
              alert('no module found for this template');
              return false;
            }
            data=JSON.parse(result);  
            $('#page_modules_id').find('select').empty();
            $('#page_modules_id').show();
            $.each(data, function(i, value) { 
              $('#page_modules_id').find('select').append($('<option>').text(value).attr('value', value));
            });
            }
        });
       }else{
        alert('please select the page');
       }
    });

      //footer Management page
       $("#footer_site_id").change(function(){
       var siteid= $("select[name='site_id']").val();
       var footer_management_page=true;
       if(siteid){
        $.ajax({
          url: ajaxhandler,
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
          type: 'POST',
          data: {
            "siteid": siteid,
            "footer_management_page": footer_management_page
            },
          success: function(result){
            if(result=='false'){
            $('.foot_hide_data').show();
            $('#edit_foot_button').hide();
            }
            else{
            $('.foot_hide_data').hide();
            $('#edit_foot_button').show();
            }
            }
        });
       }else{
        alert('There is problem in selecting the site try again later');
       }
    });
       //footer page edit button click
       $('#edit_foot_button').click(function(event) {
        site_id=$("#footer_site_id option:selected").val();
        if(!site_id){
          alert('please select the site first');
          return false;
        }
        url="footer?edit=yes && siteid="+site_id;
        window.location.href = url;
       });

       //slug check for category admin page
       $('#cat_title_id').focusout(function(){
        var title=$(this).val();
        var table='site_categories';
        var site_id=$("#cat_title_id").val();
        title=title.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');
        if(check_slug(table,title,site_id)=='true'){
        $('#cat_slug_id').val(title);
        }
        });
       //slug check for stores admin page
       $('#store_title_id').focusout(function(){
        var title=$(this).val();
        var table='site_stores';
        var site_id=$("#store_title_id").val();
        title=title.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');
        if(check_slug(table,title,site_id)=='true'){
        $('#store_slug_id').val(title);
        }
        });
       //slug check for blogs admin page
       $('#blog_title_id').focusout(function(){
        var title=$(this).val();
        var table='site_blogs';
        var site_id=$("#blog_site_select").val();
        title=title.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');
        if(check_slug(table,title,site_id)=='true'){
        $('#blog_slug_id').val(title);
        }
        });
       //slug check for menu admin page
       $('#menu_title_id').focusout(function(){
        var title=$(this).val();
        var table='site_menu';
        var site_id=$("input[name='site_id']").val();
        title=title.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');
        if(check_slug(table,title,site_id)=='true'){
        $('#menu_slug_id').val(title);
        }
        });
       function check_slug(table,slug,site_id){
        var status=null;
          $.ajax({
          url:ajaxhandler,
          async:false,
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
          data: {
            'checkslug': 'yes',
            'site_id': site_id,
            'table': table,
            'slug': slug
          },
          type: 'POST',
          success: function (result) {
            console.log(result);
          if(result=='true'){
            status="true";
          }
          else{
            alert('slug already taken cant choose this slug');
          }
          },
          error:function() {
           alert('error occur try again later');
           }
          });
          return status;
       }
       //get all stores against site id
        function get_store_site_id(site_id){
          $.ajax({
          url:ajaxhandler,
          async:false,
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
          data: {
            'get_store_site_id': 'get_store_with_site_id',
            'site_id': site_id
          },
          type: 'POST',
          success: function (result) {
          if(result){
          store_data=JSON.parse(result);
          }
          },
          error:function() {
           alert('error occur try again later');
           }
          });
          return store_data;
       }
       //get all categories against site id
        function get_category_site_id(site_id){
          $.ajax({
          url:ajaxhandler,
          async:false,
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
          data: {
            'get_category_site_id': 'get_category_with_site_id',
            'site_id': site_id
          },
          type: 'POST',
          success: function (result) {
          if(result){
          category_data=JSON.parse(result);
          }
          },
          error:function() {
           alert('error occur try again later');
           }
          });
          return category_data;
       }

       // admin menu page site selection check wheater site menu exists or not
       $("#menu_site_select").change(function(){
       var siteid= $("#menu_site_select").val();
       var menu_admin_page='yes';
       if(siteid){
        $.ajax({
          url: ajaxhandler,
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
          type: 'POST',
          data: {
            "site_id": siteid,
            "menu_admin_page": menu_admin_page
            },
          success: function(result){
            if(result=='true'){
            alert('Menu Already exists')
            }
            else{
            $('.hide_data').show();
            }
            }
        });
       }else{
        alert('There is problem in selecting the site try again later');
       }
    });

       //on edit button click check site_id on admin menu page
       $("#check_menu_site_id").click(function(event) {
        if($('#menu_site_select').val()!=0){
        site_id=$('#menu_site_select').val();
        url="menu?edit=yes && siteid="+site_id;
        window.location.href = url;
        }
        else{
          alert('select site id first');
        }
       });

       //admin panel coupons site selection get stores and categories
       $("#coupon_site_select").change(function(){
       var site_id= $("#coupon_site_select").val();
       if(site_id){
        data=get_store_site_id(site_id);
        if(!data.length==0){
          $('#coupons_store_id').empty();
          $('.hide_coupons_admin').show();
            $.each(data, function(i, value) {
              console.log(value);
              $('#coupons_store_id').append($('<option>').text(value.title).attr('value', value.store_id));
          });
          }
          else{
            alert('no stores found against this site, Must require store to save the coupon');
            $('.hide_coupons_admin').hide();
          }
        data=get_category_site_id(site_id);
        if(!data.length==0){
          $('#coupons_cat_id').empty();
          $('.hide_coupons_cats').show();
            $.each(data, function(i, value) {
              $('#coupons_cat_id').append($('<option>').text(value.title).attr('value', value.cat_id));
          });
          }
          else{
            alert('no categories found against this site');
            $('.hide_coupons_cats').hide();
          }
       }else{
        alert('please select the site first');
       }
    });
      //admin panel blogs site id selection get stores and categories
       $("#blog_site_select").change(function(){
       var site_id= $("#blog_site_select").val();
       if(site_id){
        data=get_store_site_id(site_id);
        if(!data.length==0){
          $('#blog_storeid_select').empty();
          $('.hide_relations_store').show();
            $.each(data, function(i, value) {
              console.log(value);
              $('#blog_storeid_select').append($('<option>').text(value.title).attr('value', value.store_id));
          });
          }
          else{
            alert('no stores found against this site');
            $('.hide_relations_store').hide();
          }
        data=get_category_site_id(site_id);
        if(!data.length==0){
          $('#blog_catid_select').empty();
          $('.hide_relations_cat').show();
            $.each(data, function(i, value) {
              console.log(value);
              $('#blog_catid_select').append($('<option>').text(value.title).attr('value', value.cat_id));
          });
          }
          else{
            alert('no categories found against this site');
            $('.hide_relations_cat').hide();
          }
       }else{
        alert('please select the site first');
       }
    });
      //admin panel stores site id selection get categories
       $("#store_site_select").change(function(){
       var site_id= $("#store_site_select").val();
       if(site_id){
        data=get_category_site_id(site_id);
        if(!data.length==0){
          $('#store_catid_select').empty();
          $('.hide_relations_cat').show();
            $.each(data, function(i, value) {
              $('#store_catid_select').append($('<option>').text(value.title).attr('value', value.cat_id));
          });
          }
          else{
            alert('no categories found against this site');
            $('.hide_relations_cat').hide();
          }
       }else{
        alert('please select the site first');
       }
    });
       });