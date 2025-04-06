UPDATE Movies SET Status = 'Available' 
AND ReturnDate = NULL;

DELETE FROM Transactions;
DELETE From TransactionMovies;