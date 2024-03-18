<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class DataController extends Controller
{
    private $dataUrl = 'https://www.digilabs.cz/hiring/data.php';
    private $memeImageUrl = 'https://www.digilabs.cz/hiring/chuck.jpg';

    public function joke()
    {
        $response = Http::get($this->dataUrl);
        
        if ($response->successful()) {
            $jokes = collect($response->json())
                ->pluck('joke')
                ->filter(function ($joke) {
                    return mb_strlen($joke) <= 120;
                })
                ->values();
            
            if ($jokes->isNotEmpty()) {
                $joke = $jokes->random();
                $middle = mb_strlen($joke) / 2;
                $firstPartEnd = mb_strrpos($joke, ' ', $middle - mb_strlen($joke));
                if ($firstPartEnd === false) {
                    $firstPartEnd = round($middle);
                }
                $firstPart = mb_substr($joke, 0, $firstPartEnd);
                $secondPart = mb_substr($joke, $firstPartEnd + 1);
    
                // Přiřazení URL meme obrázku do lokální proměnné
                $memeImageUrl = $this->memeImageUrl;
    
                // Použití lokální proměnné v compact funkci
                return view('joke', compact('firstPart', 'secondPart', 'memeImageUrl'));
            }
        }
        
        return response()->json(['error' => 'No suitable joke found or failed to retrieve data.'], 404);
    }

    public function initials()
    {
        $response = Http::get($this->dataUrl);
        
        if ($response->successful()) {
            $data = collect($response->json())
                ->filter(function ($item) {
                    $nameParts = explode(' ', $item['name']); // Rozdělení jména na části
                    if (count($nameParts) < 2) {
                        return false; // Pokud jméno nemá alespoň dvě slova, přeskočit
                    }
                    $firstNameInitial = mb_substr($nameParts[0], 0, 1); // První písmeno křestního jména
                    $lastNameInitial = mb_substr(end($nameParts), 0, 1); // První písmeno příjmení
                    return strtoupper($firstNameInitial) === strtoupper($lastNameInitial); // Porovnání, zda se shodují
                })
                ->values(); // Resetování klíčů pole po filtrování
    
            // Předání filtrovaných dat do view
            return view('initials', ['data' => $data]);
        }
    
        // Pokud nedojde k načtení dat nebo pokud žádný záznam nesplňuje kritéria, vrátí chybovou zprávu
        return response()->json(['error' => 'No data found or failed to retrieve data.'], 404);
    }
    

    public function mathcheck()
    {
        $response = Http::get($this->dataUrl);
        
        if ($response->successful()) {
            $data = collect($response->json())
                ->filter(function ($item) {
                    // Zkontroluj, zda jsou všechny potřebné klíče přítomné a zda je secondNumber různé od nuly, aby se předešlo dělení nulou
                    if (!isset($item['firstNumber'], $item['secondNumber'], $item['thirdNumber']) || $item['secondNumber'] == 0) {
                        return false;
                    }
                    
                    $firstNumber = $item['firstNumber'];
                    $secondNumber = $item['secondNumber'];
                    $thirdNumber = $item['thirdNumber'];
    
                    // Zkontroluj, zda je firstNumber sudé
                    $isFirstNumberEven = $firstNumber % 2 === 0;
    
                    // Zkontroluj, zda výpočet odpovídá
                    $matchesCalculation = ($firstNumber / $secondNumber) == $thirdNumber;
    
                    return $isFirstNumberEven && $matchesCalculation;
                })
                ->values(); // Resetování klíčů pole po filtrování
    
            // Předání filtrovaných dat do view
            return view('mathcheck', ['data' => $data]);
        }
    
        // Pokud nedojde k načtení dat nebo pokud žádný záznam nesplňuje kritéria, vrátí chybovou zprávu
        return response()->json(['error' => 'No data found or failed to retrieve data.'], 404);
    }
    

    public function createdat()
    {
        $response = Http::get($this->dataUrl);
        
        if ($response->successful()) {
            $data = collect($response->json())
                ->filter(function ($item) {
                    $createdAt = Carbon::parse($item['createdAt']); // Převedení řetězce na Carbon instanci
                    $oneMonthAgo = Carbon::now()->subMonth(); // Datum před měsícem
                    $oneMonthAhead = Carbon::now()->addMonth(); // Datum za měsíc
                    return $createdAt->between($oneMonthAgo, $oneMonthAhead); // Filtrace dat v požadovaném intervalu
                })
                ->values(); // Resetování klíčů po filtraci
    
            // Předání filtrovaných dat do view
            return view('createdat', ['data' => $data]);
        }
    
        // Pokud nedojde k načtení dat nebo pokud žádný záznam nesplňuje kritéria, vrátí chybovou zprávu
        return response()->json(['error' => 'No suitable records found or failed to retrieve data.'], 404);
    }
}