function searchBooks() {
  const query = document.getElementById("searchBox").value.toLowerCase();
  const books = document.getElementsByClassName("book");

  Array.from(books).forEach(book => {
    const title = book.querySelector("h3").textContent.toLowerCase();
    const author = book.querySelector("p").textContent.toLowerCase();
    if (title.includes(query) || author.includes(query)) {
      book.style.display = "block";
    } else {
      book.style.display = "none";
    }
  });
}
