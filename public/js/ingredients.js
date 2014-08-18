/**
 * Ingredients
 */

$().ready(function() {
    $('.ingredient-add').on('click', function() {
        $('#ingredient-add-modal').modal('show').find('.modal-title').text('Add ingredient');
    });

    $('#ingredient-add-modal input').on('change', function() {
        var $this = $(this),
            divide;

        if ($.trim($this.val()).match(/^\d+(\.\d+)?\/\d+(\.\d+)?$/) === null) {
            return;
        }

        divide = $this.val().split('/');
        $this.val(Math.round(divide[0] / divide[1] * 10000) / 100);
    });

    $('#ingredient-add-submit').on('click', function() {
        var $form = $('#ingredient-add-modal form'),
            id = $('#ingredient-id', $form).val();

        $.ajax({
            url: '/ingredients' + (id ? '/' + id : ''),
            type: (id ? 'PUT' : 'POST'),
            data: $form.serialize()
        }).done(function(response) {
            console.log(response);
            location.reload();
        });
    });

    $('.ingredient-delete').on('click', function(e) {
        var id = $(this).closest('tr').data('id'),
            name = $(this).parent().siblings(':first').text();

        // @todo: set id as a variable instead of data of DOM element
        $('#ingredient-delete-modal')
            .modal('show')
            .find('.ingredient-delete-name').text(name).data('id', id);

        e.stopPropagation();
    });

    $('#ingredient-delete-submit').on('click', function() {
        var id = $('#ingredient-delete-modal .ingredient-delete-name').data('id');

        $.ajax({
            url: '/ingredients/' + id,
            type: 'DELETE',
        }).done(function(response) {
            console.log(response);
            location.reload();
        });
    });

    $('.ingredient-edit').on('click', function() {
        var id = $(this).data('id');

        $.ajax({
            url: '/ingredients/' + id,
            type: 'GET'
        }).done(function(response) {
            console.log(response);
            var $modal = $('#ingredient-add-modal');


            $('.modal-title', $modal).text('Edit ingredient');
            $('form :input', $modal).each(function() {
                var key = $(this).attr('name').replace(/-/g, '_');
                if ($.type(response[key]) !== 'undefined') {
                    $(this).val(response[key]);
                }
            });
            $modal.modal('show');
        });
    });

    $('#ingredient-add-modal form :input').on('keydown', function(e) {
        if (e.which == 13) {
            $('#ingredient-add-submit').trigger('click');
        }
    });
});
