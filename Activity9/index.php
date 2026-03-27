<?php
declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| BOOK CLASS
|--------------------------------------------------------------------------
| Represents a single book in the library.
*/

class Book {
    public string $title;
    public string $author;
    public string $isbn;
    public bool $available;

    public function __construct(string $title, string $author, string $isbn, bool $available = true)
    {
        $this->title     = $title;
        $this->author    = $author;
        $this->isbn      = $isbn;
        $this->available = $available;
    }
}

/*
|--------------------------------------------------------------------------
| LIBRARY CLASS
|--------------------------------------------------------------------------
| Manages a collection of Book objects.
*/

class Library {
    private array $books = [];

    // Add a book
    public function addBook(Book $book): void
    {
        $this->books[$book->isbn] = $book;
    }

    // Remove a book
    public function removeBook(string $isbn): bool
    {
        if (isset($this->books[$isbn])) {
            unset($this->books[$isbn]);
            return true;
        }
        return false;
    }

    // Search by title or author
    public function search(string $query): array
    {
        $results = [];
        foreach ($this->books as $book) {
            if (stripos($book->title, $query) !== false ||
                stripos($book->author, $query) !== false) {
                $results[] = $book;
            }
        }
        return $results;
    }

    // Borrow a book
    public function borrowBook(string $isbn): bool
    {
        if (!isset($this->books[$isbn])) {
            echo "Book with ISBN $isbn does not exist.\n";
            return false;
        }

        if (!$this->books[$isbn]->available) {
            echo "Book with ISBN $isbn is already borrowed.\n";
            return false;
        }

        $this->books[$isbn]->available = false;
        echo "Book with ISBN $isbn has been borrowed.\n";
        return true;
    }

    // Return a book
    public function returnBook(string $isbn): bool
    {
        if (!isset($this->books[$isbn])) {
            echo "Book with ISBN $isbn does not exist.\n";
            return false;
        }

        if ($this->books[$isbn]->available) {
            echo "Book with ISBN $isbn is already available.\n";
            return false;
        }

        $this->books[$isbn]->available = true;
        echo "Book with ISBN $isbn has been returned.\n";
        return true;
    }

    // Get all books
    public function getBooks(): array
    {
        return $this->books;
    }

    // Save library to file
    public function saveToFile(string $filename = "library.json"): void
    {
        $data = [];

        foreach ($this->books as $book) {
            $data[] = [
                "title"     => $book->title,
                "author"    => $book->author,
                "isbn"      => $book->isbn,
                "available" => $book->available
            ];
        }

        file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT));
        echo "Library saved to $filename\n";
    }

    // Load library from file
    public function loadFromFile(string $filename = "library.json"): void
    {
        if (!file_exists($filename)) {
            echo "No saved library found.\n";
            return;
        }

        $data = json_decode(file_get_contents($filename), true);

        foreach ($data as $item) {
            $this->addBook(new Book(
                $item["title"],
                $item["author"],
                $item["isbn"],
                $item["available"]
            ));
        }

        echo "Library loaded from $filename\n";
    }
}

/*
|--------------------------------------------------------------------------
| HELPER FUNCTIONS
|--------------------------------------------------------------------------
*/

function displayBook(Book $book): void
{
    echo "Title: {$book->title}\n";
    echo "Author: {$book->author}\n";
    echo "ISBN: {$book->isbn}\n";
    echo "Status: " . ($book->available ? "Available" : "Borrowed") . "\n";
    echo "---------------------\n";
}

function displayAllBooks(array $books): void
{
    foreach ($books as $book) {
        displayBook($book);
    }
}

/*
|--------------------------------------------------------------------------
| INITIAL LIBRARY SETUP
|--------------------------------------------------------------------------
*/

$library = new Library();

$library->addBook(new Book("The Great Gatsby", "F. Scott Fitzgerald", "9780743273565"));
$library->addBook(new Book("To Kill a Mockingbird", "Harper Lee", "9780446310789"));
$library->addBook(new Book("1984", "George Orwell", "9780451524935"));

/*
|--------------------------------------------------------------------------
| OPTIONAL COMMAND-LINE INTERFACE
|--------------------------------------------------------------------------
*/

if (php_sapi_name() === "cli") {

    echo "\nLibrary Management CLI\n";
    echo "--------------------------------------\n";

    while (true) {
        echo "\nChoose an option:\n";
        echo "1. View All Books\n";
        echo "2. Search Books\n";
        echo "3. Borrow Book\n";
        echo "4. Return Book\n";
        echo "5. Save Library\n";
        echo "6. Load Library\n";
        echo "7. Exit\n";

        $choice = readline("Enter choice (1-7): ");

        switch ($choice) {

            case "1":
                displayAllBooks($library->getBooks());
                break;

            case "2":
                $query = readline("Enter title or author: ");
                $results = $library->search($query);
                displayAllBooks($results);
                break;

            case "3":
                $isbn = readline("Enter ISBN to borrow: ");
                $library->borrowBook($isbn);
                break;

            case "4":
                $isbn = readline("Enter ISBN to return: ");
                $library->returnBook($isbn);
                break;

            case "5":
                $library->saveToFile();
                break;

            case "6":
                $library->loadFromFile();
                break;

            case "7":
                echo "Goodbye!\n";
                exit;

            default:
                echo "Invalid choice.\n";
        }
    }
}

/*
|--------------------------------------------------------------------------
| DEMONSTRATION OUTPUT (WEB MODE)
|--------------------------------------------------------------------------
*/

if (php_sapi_name() !== "cli") {

    echo "<pre>";

    echo "Initial Library State:\n";
    displayAllBooks($library->getBooks());

    echo "\nSearch Results for 'Gatsby':\n";
    displayAllBooks($library->search("Gatsby"));

    $library->borrowBook("9780743273565");

    echo "\nLibrary State After Borrowing:\n";
    displayAllBooks($library->getBooks());

    $library->returnBook("9780743273565");

    echo "\nFinal Library State:\n";
    displayAllBooks($library->getBooks());

    echo "</pre>";
}
