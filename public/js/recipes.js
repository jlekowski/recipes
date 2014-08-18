/**
 * Recipe
 */

$().ready(function() {
    $('.recipe-ingredient-add').on('click', function() {
        $('#recipe-ingredient-add-modal').modal('show').find('.modal-title').text('Add recipe ingredient');
    });

    $('#recipe-ingredient-add-submit').on('click', function() {
        var $form = $('#recipe-ingredient-add-modal form'),
            id = $('#recipe-ingredient-id', $form).val();

        $.ajax({
            url: '/recipeIngredients' + (id ? '/' + id : ''),
            type: (id ? 'PUT' : 'POST'),
            data: $form.serialize()
        }).done(function(response) {
            console.log(response);
            location.reload();
        });
    });

    $('.recipe-ingredient-delete').on('click', function(e) {
        var id = $(this).closest('tr').data('id'),
            name = $(this).parent().siblings(':first').text();

        // @todo: set id as a variable instead of data of DOM element
        $('#recipe-ingredient-delete-modal')
            .modal('show')
            .find('.recipe-ingredient-delete-name').text(name).data('id', id);

        e.stopPropagation();
    });

    $('#recipe-ingredient-delete-submit').on('click', function() {
        var id = $('#recipe-ingredient-delete-modal .recipe-ingredient-delete-name').data('id');

        $.ajax({
            url: '/recipeIngredients/' + id,
            type: 'DELETE',
        }).done(function(response) {
            console.log(response);
            location.reload();
        });
    });

    $('.recipe-ingredient-edit').on('click', function() {
        var id = $(this).data('id');

        $.ajax({
            url: '/recipeIngredients/' + id,
            type: 'GET'
        }).done(function(response) {
            console.log(response);
            var $modal = $('#recipe-ingredient-add-modal');


            $('.modal-title', $modal).text('Edit recipe ingredient');
            $('form :input', $modal).each(function() {
                var key = $(this).attr('name').replace(/-/g, '_');
                if ($.type(response[key]) !== 'undefined') {
                    $(this).val(response[key]);
                }
            });
            $modal.modal('show');
        });
    });
});
