<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;
use League\Csv\Writer;

class CsvService
{
    /**
     * Import data from a CSV file
     *
     * @param UploadedFile $file
     * @param string $modelClass
     * @return array
     */
    public function importFromCsv(UploadedFile $file, string $modelClass): array
    {
        // Store the uploaded file temporarily
        $path = $file->store('temp');
        $filePath = Storage::path($path);
        
        // Read the CSV file
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0); // Set the first row as header
        
        $header = $csv->getHeader(); // Returns the CSV header record
        $records = $csv->getRecords(); // Returns all the CSV records
        
        $imported = 0;
        $errors = [];
        
        // Process each record
        foreach ($records as $record) {
            try {
                // Create a new model instance with the record data
                $modelClass::create($record);
                $imported++;
            } catch (\Exception $e) {
                $errors[] = [
                    'record' => $record,
                    'error' => $e->getMessage()
                ];
            }
        }
        
        // Delete the temporary file
        Storage::delete($path);
        
        return [
            'imported' => $imported,
            'errors' => $errors
        ];
    }
    
    /**
     * Export data to a CSV file
     *
     * @param string $modelClass
     * @param array $columns
     * @return string
     */
    public function exportToCsv(string $modelClass, array $columns): string
    {
        // Get all records from the model
        $records = $modelClass::all($columns)->toArray();
        
        // Create a new CSV writer
        $csv = Writer::createFromFileObject(new \SplTempFileObject());
        
        // Insert the header
        $csv->insertOne($columns);
        
        // Insert all the records
        $csv->insertAll($records);
        
        // Generate a unique filename
        $filename = 'export_' . time() . '.csv';
        
        // Save the CSV file to storage
        Storage::put($filename, $csv->toString());
        
        return $filename;
    }
}