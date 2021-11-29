## CSV App

App takes a CSV file and imports it into a MySQL database (contacts table), filtering duplicates and validationg data.  After the file is processed, invalid entries are inserted into a bad contacts table.  

The bad contacts table uses a batch key, so even if the file is updated and has the same file name, sorting and selecting can be filtered by batch number.

The files are saved and reported to a job, which processes the file by batch.


### App Features

- **[Route Model Binding](https://github.com/dreboard/csv-app/blob/master/routes/api.php)**
- **[Resource Collections](https://github.com/dreboard/csv-app/blob/master/app/Http/Resources/ContactsResource.php)**
- **[API Version Routes](https://github.com/dreboard/csv-app/blob/master/routes/api.php)**
- **[File Import Jobs](https://github.com/dreboard/csv-app/blob/master/app/Jobs/CSVImportJob.php)**
- **[Custom Requests](https://github.com/dreboard/csv-app/tree/master/app/Http/Requests)**
- **[Mailables](https://github.com/dreboard/csv-app/blob/master/app/Mail/CSVFileProcessed.php)**
- **[Repository Pattern](https://github.com/dreboard/csv-app/tree/master/app/Repositories)**
- **[Model Observers](https://github.com/dreboard/csv-app/blob/master/app/Observers/ContactObserver.php)**
- **[Custom Exception Renderables](https://github.com/dreboard/csv-app/blob/master/app/Exceptions/Handler.php)**
- **[Custom ServiceProviders](https://github.com/dreboard/csv-app/blob/master/app/Providers/ContactServiceProvider.php)**
- **[Interface Dependency Injection](https://github.com/dreboard/csv-app/blob/master/app/Providers/ContactServiceProvider.php)**
- **[Unit Testing](https://github.com/dreboard/csv-app/tree/master/tests/Unit)**


## Contact Routes

| URI                       | Action | Method                     | Fields (All required)                        |
|---------------------------|--------|----------------------------|----------------------------------------------|
| api/V1/contacts           | GET    | Get all contacts           | id                                           |
| api/V1/contacts           | POST   | Create a contact           | first_name, last_name,   email, phone_number |
| api/V1/contacts/{contact} | GET    | Get contact by ID          | id                                           |
| api/V1/contacts/{contact} | PUT    | Edit contact               | first_name, last_name,   email, phone_number |
| api/V1/contacts/{contact} | DELETE | Delete contact             | id                                           |
| api/V1/date_range         | POST   | Get list before/after date | when=after/before, date=Y-m-d                |

