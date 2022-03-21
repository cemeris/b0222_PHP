const req = new Request()
const game_board = document.querySelector('.game_board')
const message_element = document.querySelector('.message')

req.get('api.php?name=get_moves', function (response) {
    for (let coord in response.moves) {
        game_board.children[coord - 1].textContent = response.moves[coord]
    }
    if (response.hasOwnProperty('winner')) {
        message_element.textContent = response.winner + " has won the game!"
    }
})

game_board.onclick = function (event) {
    event.preventDefault()
    if (event.target.tagName == 'A') {
        let coord = event.target.dataset.coord
        const data = new FormData()
        data.append('coord', coord)
        req.post('api.php?name=move', data, function (response) {
            event.target.textContent = response.symbol
            if (response.hasOwnProperty('winner')) {
                message_element.textContent = response.winner + " has won the game!"
            }
        })
    }
}

document.querySelector('form').onsubmit = function (event) {
    event.preventDefault()
    const form = this
    const data = new FormData(form)
    req.post(form.getAttribute('action'), data, function (response) {
        form.querySelector('input').value = ''
        alert(JSON.stringify(response))
    })
}

document.querySelector('.reset').onclick = function(event) {
    event.preventDefault();
    req.get('api.php?name=reset', function (response) {
        for(let cell of game_board.children) {
            cell.textContent = '';
        }
        message_element.textContent = ''
    })
}