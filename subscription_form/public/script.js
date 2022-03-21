const req = new Request();

req.get('api.php?name=getSubscribers', function (response) {
    for (let subscriber of response.subscribers) {
        printSubscriber(subscriber)
    }
})

document.querySelector('form').onsubmit = function(event) {
    event.preventDefault()
    if(document.getElementById('subscription_check').checked) {
        const url = this.getAttribute('action')
        let form = this;
        req.post(url, new FormData(this), function (response) {
            if (response.hasOwnProperty('entity')) {
                printSubscriber(response.entity)
                for (let input of form.querySelectorAll('input')) {
                    input.value = ''
                    input.checked = false
                }
                document.getElementById('message').textContent = ''
            }
        })
    }
    else {
        document.getElementById('message').textContent = "please check the checkbox!"
    }
}

function printSubscriber(subscriber) {
    const row = document.createElement('tr')
    const delete_btn = document.createElement('a')
    delete_btn.setAttribute('href', 'api.php?name=delete')
    delete_btn.classList.add('delete')
    delete_btn.textContent = 'delete'
    delete_btn.dataset.id = subscriber.id
    delete_btn.onclick = deleteHandler

    let cell = document.createElement('td')
    cell.textContent = subscriber.name
    row.append(cell)

    cell = document.createElement('td')
    cell.textContent = subscriber.email
    row.append(cell)

    cell = document.createElement('td')
    cell.append(delete_btn)
    row.append(cell)

    document.querySelector('#subscribers_list tbody').append(row)
}

function deleteHandler(event) {
    event.preventDefault()
    const url = this.getAttribute('href')
    const data = new FormData()
    data.append('id', this.dataset.id)
    const btn = this

    req.post(url, data, function (response) {
        btn.parentNode.parentNode.remove()
    });
}