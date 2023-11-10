function searchBlock() {
    let input = document.getElementById("inputSearchBlock");
    let filter = input.value.toUpperCase();
    let ul = document.getElementById("fast_search_block");
    let li = ul.getElementsByClassName('col');

    // Перебирайте все элементы списка и скрывайте те, которые не соответствуют поисковому запросу
    for (let i = 0; i < li.length; i++) {
        if (li[i].innerHTML.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
}

document.addEventListener('keyup', searchBlock);