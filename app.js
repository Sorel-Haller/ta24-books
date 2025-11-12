const searchInput = document.getElementById('search');
const bookAnchors = document.getElementsByClassName('book');

searchInput.addEventListener('input', e => {

    console.log(seaqrchInput.value);

    Array.from(bookAnchors).forEach(book => {
        if (title.toLowerCase().includes(searchInput.value.toLowerCase()) ){

        bookListContent += '<li><a class="book" href="${href}">${title}</a></li>';
        } else {
            bookListContent = 'hidden';
        };
    }); 
});

