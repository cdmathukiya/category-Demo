
function scrollTop() {
	$("body").animate({
        scrollTop: 0
    }, 1000);
}
	
$(document).ready(function(){

    $(document).off('click', '.add-main-category').on('click', '.add-main-category', function () {
        var li = $(".blank-li").clone();
        li.removeClass('d-none blank-li');
        $('.nestable-list').find('ul:first').prepend(li);
    });

    $(document).off('click', '.add-btn').on('click', '.add-btn', function () {
        var addBtn = $(this);
        var id = addBtn.closest('.category-detail').find('.edit-text').attr('data-id');

        var li = $(".blank-li").clone();
        li.removeClass('d-none blank-li');
        li.find('.edit-text').attr('data-parent',id);

        if(addBtn.closest('li').find('ul:first').length) {
            addBtn.closest('li').find('ul:first').prepend(li);
        } else {
            addBtn.closest('li').append(li);
        }
    });
    
    $(document).off('click', '.edit-btn').on('click', '.edit-btn', function () {
        var editBtn = $(this);
        editBtn.closest('.category-detail').find('.display-text, .edit-group').addClass('d-none');
        editBtn.closest('.category-detail').find('.edit-text, .save-group').removeClass('d-none');
    });

    $(document).off('click', '.delete-btn').on('click', '.delete-btn', function () {
        var deleteBtn = $(this);
        var deleteId = deleteBtn.data('id');
        if(deleteId){
            bootbox.confirm({
                size: 'small',
                title: "<span class='text-danger'>Alert !</span>",
                message: "Are You Sure You Want to Delete This Record?",
                buttons: {
                   cancel: {
                       label: '<i class="fa fa-times"></i> Cancel'
                   },
                   confirm: {
                       label: '<i class="fa fa-check"></i> Confirm',
                       class: 'btn-danger'
                   }
                },
                callback: function (result) {
                    if (result) {
                        // window.location.href = deleteUrl+deleteId;

                        var btnText = deleteBtn.html();
                        $.ajax({
                            url: deleteUrl+deleteId,
                            type: 'Get',
                            dataType: 'json',
                            beforeSend: function () {
                                $('.error,.submit_notification').html('').text('');
                                deleteBtn.attr("disabled", "disabled").html('<i class="fa fa-spin fa-spinner"></i>');
                            },
                            success: function (result) {
                                deleteBtn.removeAttr("disabled").html(btnText);
                                if (result.status === 'success') {
                                    $('.error').html('');
                                    deleteBtn.closest('li').remove();
                                    $('.submit_notification').html('<span class="text-success error">' + result.message + '</span>');
                                } else {
                                    $('.error').html('');
                                    scrollTop();
                                    $('.submit_notification').html('<span class="text-danger error">' + result.message + '</span>');
                                }
                            },
                            error: function (e) {
                                deleteBtn.removeAttr("disabled").html(btnText);
                                $('.submit_notification').html('<span class="text-danger error">Something Went Wrong!... Please try again after refresh</span>');
                            }
                        });
                    }
                }
            });
        } else {
            deleteBtn.closest('li').remove();
        }
    });

    $(document).off('click', '.save-btn').on('click', '.save-btn', function () {
        var saveBtn = $(this);
        var newVal = saveBtn.closest('.category-detail').find('.edit-text').val().trim();
        var id = saveBtn.closest('.category-detail').find('.edit-text').data('id');
        var parentId = saveBtn.closest('.category-detail').find('.edit-text').data('parent');
        
        if(newVal == "" || newVal == null){
            alert('Please insert category name');
            return false;
        }

        var btnText = saveBtn.html();

        $.ajax({
            url: saveUrl,
            type: 'post',
            dataType: 'json',
            data: {'name': newVal, 'id' : id, 'parent_id' : parentId},
            headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    },
            beforeSend: function () {
                $('.error,.submit_notification').html('').text('');
                saveBtn.attr("disabled", "disabled").html('<i class="fa fa-spin fa-spinner"></i>');
            },
            success: function (result) {
                saveBtn.removeAttr("disabled").html(btnText);
                if (result.status == 'validation') {
                    $.each(result, function(i, val) {
                        if (val != "") {
                            $('.submit_notification').html('<span class="text-success error">' + val + '</span>');
                        }
                    });
                    scrollTop();
                } else if (result.status === 'success') {
                    $('.error').html('');
                    saveBtn.closest('.category-detail').find('.edit-text, .save-group').addClass('d-none');
                    saveBtn.closest('.category-detail').find('.display-text, .edit-group').removeClass('d-none');
                    saveBtn.closest('.category-detail').find('.display-text').text(newVal);

                    saveBtn.closest('.category-detail').find('.edit-text').attr('data-id',result.id);
                    saveBtn.closest('.category-detail').find('.edit-text, .add-btn, .delete-btn').attr('data-id',result.id);
                    $('.submit_notification').html('<span class="text-success error">' + result.message + '</span>');
                } else {
                    $('.error').html('');
                    scrollTop();
                    $('.submit_notification').html('<span class="text-danger error">' + result.message + '</span>');
                }
            },
            error: function (e) {
                saveBtn.removeAttr("disabled").html(btnText);
                $('.submit_notification').html('<span class="text-danger error">Something Went Wrong!... Please try again after refresh</span>');
            }
        });

        
    });

    $(document).off('click', '.cancel-btn').on('click', '.cancel-btn', function () {
        var cancelBtn = $(this);
        var oldVal = cancelBtn.closest('.category-detail').find('.display-text').text();
        var id = cancelBtn.closest('.category-detail').find('.edit-text').data('id');

        if(id){
            cancelBtn.closest('.category-detail').find('.edit-text, .save-group').addClass('d-none');
            cancelBtn.closest('.category-detail').find('.display-text, .edit-group').removeClass('d-none');
            cancelBtn.closest('.category-detail').find('.edit-text').val(oldVal);
        } else {
            cancelBtn.closest('li').remove();
        }
    });
});