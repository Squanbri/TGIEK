<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://ab.tgiek.ru/assets/css/bootstrap.min.css">
  <title>Даты</title>
</head>
<body>
  <a href='https://ab.tgiek.ru/' class='btn btn-primary m-3'>Назад</a>
  <main class='container px-3 pt-3 pb-0 border mt-0 mb-5 mx-auto'>
    <h1 class='m-3 mb-5'>Даты</h1>

    <div class='d-flex justify-content-between mb-4'>
      <input class='form-control w-50' value='' data-id='${el.id}' id='addInput'>
      <button class='btn btn-success' id='addButton'> Добавить </button>
    </div>

    <table class="table">
      <thead>
        <tr>
          <th scope="col">Дата</th>
          <th></th>
        </tr>
      </thead>
      <tbody id='tBody'>      
      </tbody>
    </table>
  </main>
</body>
<script>
  const tBody = document.querySelector('tbody')

  const getRecordings = () => {
    fetch('https://ab.tgiek.ru/php/getData/dates.php')
    .then(res => res.json())
    .then(recrodings => {
      tBody.innerHTML = ''
      recrodings.forEach(el => {
        tBody.innerHTML += `
          <tr>
            <td><input class='form-control w-50 dates' value='${el.date}' data-id='${el.id}'></td>
            <td class='d-flex justify-content-end'> <button class='btn btn-danger' id='delete' data-id='${el.id}'>&times;</button> </td>
          </tr>
        `
      })

      const btns = document.querySelectorAll('#delete')
      btns.forEach(btn => {
        btn.addEventListener('click', (e) => {
          const id = btn.getAttribute('data-id')
          fetch('https://ab.tgiek.ru/php/getData/dates.php', {
            method: 'delete',
            body: JSON.stringify({
              id: id, 
            })
          })

          e.target.parentNode.parentNode.style.display = 'none'
        })
      })

      const inputsDate = document.querySelectorAll('.dates')
      inputsDate.forEach(input => {
        input.addEventListener('change', e => {
          const id = e.target.getAttribute('data-id')
          const date = e.target.value
          fetch('./php/dates.php', {
            method: 'put',
            body: JSON.stringify({
              id: id,
              date: date,
            })
          })
        })
      })
    })
  }
  getRecordings()
  
  const addInput = document.querySelector('#addInput')
  const addButton = document.querySelector('#addButton')
  addButton.addEventListener('click', () => {
    const date = addInput.value
    fetch('https://ab.tgiek.ru/php/getData/dates.php', {
      method: 'post',
      body: JSON.stringify({
        date: date, 
      })
    })
    .then(res => getRecordings())
    addInput.value = ''
  })
</script>
</html>