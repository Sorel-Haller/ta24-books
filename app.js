const searchInput = document.getElementById('search');
const bookAnchors = document.getElementsByClassName('book');

searchInput.addEventListener('input', e => {

    console.log(seaqrchInput.value);

    Array.from(bookAnchors).forEach(book => {
        if (book.innerText.lowerCase().includes(seaqrchInput.value.toLowerCase()) ){
            book.classList.remove('hidden');    
        } else {
            book.classList.add('hidden');
        };
    }); 
});

