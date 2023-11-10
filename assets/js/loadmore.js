jQuery(function($){
    $('#true_loadmore').click(function(){
        const button = $(this);
        button.text('Загружаю...'); // изменяем текст кнопки, вы также можете добавить прелоадер
        var data = {
            'action': 'loadmore',
            'query': true_posts,
            'page' : current_page
        };
        $.ajax({
            url:ajaxurl, // обработчик
            data:data, // данные
            type:'POST', // тип запроса
            success:function(data){
                if( data ) {
                    button.html("Загрузить ещё");
                    button.parent().prev().prev().append(data);// вставляем новые посты
                    current_page++; // увеличиваем номер страницы на единицу
                    if (current_page === max_pages) button.remove(); // если последняя страница, удаляем кнопку
                } else {
                    button.remove(); // если мы дошли до последней страницы постов, скроем кнопку
                }
            }
        });
    });
});
