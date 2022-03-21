<?php
define('PRIVATE_DIR', __DIR__ . '/../private/');

include PRIVATE_DIR . 'bootstrap.php';

use TicTacToe\DataManager;
use TicTacToe\Referee;

header('Content-type: application/json');

$output = ['status' => false];

if (isset($_GET['name']) && is_string($_GET['name'])) {
    switch ($_GET['name']) {
        case 'move':
            if (isset($_POST['coord']) && is_string($_POST['coord'])) {
                $data_manager = new DataManager(PRIVATE_DIR. 'data.json', 9);
                $coord = (int) $_POST['coord'];

                $symbol = $data_manager->makeMove($coord);
                if ($symbol !== false) {
                    $moves = $data_manager->getMoves();
                    if (count($moves) >= 5) {
                        $referee = new Referee($moves, $data_manager->getSymbol());

                        if ($referee->hasWinner()) {
                            $data_manager->setWinner($referee->getWinner());
                            $output['winner'] = $referee->getWinner();
                        }
                    }
                    $output['symbol'] = $symbol;
                    $output['status'] = true;
                }
            }
            break;
        case 'reset':
            $data_manager = new DataManager(PRIVATE_DIR. 'data.json', 9);
            $data_manager->resetData();

            $output['status'] = true;
            $output['message'] = 'Game successfuly has been reset!';
            break;
        case 'get_moves':
            $data_manager = new DataManager(PRIVATE_DIR. 'data.json', 9);

            $output['status'] = true;
            $output['moves'] = $data_manager->getMoves();
            if ($data_manager->getWinner() != '') {
                $output['winner'] = $data_manager->getWinner();
            }
            break;
        case 'contact_form':
            $output['status'] = true;
            $output['message'] = 'Form data received';
            break;
    }
}

/*
    ✅ 1. jāuztaisa pogu
    ✅ 1.1. pārtvert notikumu
    1.2. Jānosūta pieprasijums uz serveri "api.php?name=reset"

    2. atrast datu glabātuvi 
    3. izdzērt datus

    4. Jāizdzēš vērtības no šūnām


    s
    data [coord => '4'] -> api.php?name=move
    data [player => 'user456']-> api.php?name=contact_form

*/

echo json_encode($output, JSON_PRETTY_PRINT);