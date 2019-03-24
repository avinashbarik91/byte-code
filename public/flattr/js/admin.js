tinymce.init({
  selector: 'textarea#flattr-cms-editor',
  height: 500,
  menubar: false,
  plugins: [
    "advlist autolink lists link image charmap print anchor",
    "searchreplace visualblocks code fullscreen",
    "insertdatetime media table paste imagetools code wordcount codesample"
  ],
  toolbar: "insertfile undo redo | fontsizeselect| styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | codesample | code"

});

$('#create-blog-form').submit(function(e) {   
    e.preventDefault();
    if (!validateForm('#create-blog-form'))
    {
        return false;
    }

    if ($("#create-blog-submit-btn").val() == "Update")
    {
        var functionType = "updatePost";
    }
    else
    {
        var functionType = "createPost";
    }

    //Get Form values
    var blogURL     = $("#blog-url").val().toLowerCase();
    var blogTitle   = $("#blog-title").val();
    var blogAuthor  = $("#blog-author").val();
    var blogTags    = $("#blog-tags").val();
    var blogDate    = getCurrentDate(); 
    var blogContent = tinymce.get('flattr-cms-editor').getContent();
    
    if (blogContent.trim() == "") 
    {   
        alert("Content can't be blank");
        return false;
    }

    var formValues = [];
    formValues.push({blogTitle:blogTitle, blogAuthor:blogAuthor, blogTags:blogTags, blogDate:blogDate, blogContent:blogContent});

    $.ajax({
        url: "../flattr/create_blog.php",
        dataType: "json",
        type: "POST",
        data: {
                blogURL:blogURL, 
                formValues: formValues,
                functionType: functionType
            },
        success: function(data){
            if (data.success != null)
            {
                if (functionType == "createPost")
                    alert('Blog Added');
                else
                    alert('Blog Updated');

                location.reload();
            }
            else
            {
                alert(data.error);
            }
        },
        error: function(data){

        }
    });
});

$("#blog-url").on("keyup", function(){
    this.value = this.value.toLowerCase();
    this.value = this.value.replace("- ", "-");
    this.value = this.value.replace(" ", "-");    
})

function validateForm(formId)
{  
    var is_invalid = false;  
    $(formId + " input").each(function(){
        if ($(this).val().trim() == "")
        {
            $(this).addClass("is-invalid");
            is_invalid = true;
        }
        else
        {
            $(this).addClass("is-valid");
        }
    });
    
    if (is_invalid)
    {        
        return false;
    }
    
    return true;
}

function getCurrentDate() {
    var d       = new Date();
    var month   = d.getMonth()+1;
    var day     = d.getDate();

    var output = d.getFullYear() + '-' +
        (month<10 ? '0' : '') + month + '-' +
        (day<10 ? '0' : '') + day;

    return output;
}

$(".blog-edit-btn").on("click", function(){
    var blogURL = $(this).attr("data-attribute");
    $.ajax({
        url: "../flattr/read_blog.php",
        dataType: "json",
        type: "POST",
        data: {
                blogURL:blogURL,               
                functionType: 'read_blog'
            },
        success: function(data){
            if (data.blogObj != null)
            {
                var blogObj = data.blogObj;
                var title = "Update Blog | Flattr CMS";

                $(document).prop('title', title);
                $("#create-blog-submit-btn").val("Update");
                
                $("#admin-title").html(title);
                $("#blog-url").val(blogObj.blogURL);
                $("#blog-url").prop('disabled', true);
                $("#blog-title").val(blogObj.content.blogTitle);
                $("#blog-author").val(blogObj.content.blogAuthor);
                $("#blog-tags").val(blogObj.content.blogTags);            
                tinymce.get('flattr-cms-editor').setContent(data.blogObj.content.blogContent);
                

            }
            else
            {
                alert(data.error);
            }
        },
        error: function(data){
            alert('Something went wrong!');
        }
    });
});

$(".blog-delete-btn").on('click', function(){
    $(".delete-btn-blog-final").attr('data-attribute', $(this).attr("data-attribute"));    
})

$(".delete-btn-blog-final").on('click', function(){
    var blogURL = $(this).attr("data-attribute");
   
    $.ajax({
        url: "../flattr/create_blog.php",
        dataType: "json",
        type: "POST",
        data: {
                blogURL:blogURL,               
                functionType: 'deletePost'
            },
        success: function(data){
            if (data.success != null)
            {
                alert("Blog Deleted");

                location.reload();
            }
            else
            {
                alert(data.error);
            }
        },
        error: function(data){
            alert('Something went wrong!');
        }
    });
});

