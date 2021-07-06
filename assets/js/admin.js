const tBody = document.querySelector('tbody')
const fio = document.querySelector('#fio')
const date = document.querySelector('#date-select')
const pagination = document.querySelector('#pagination')
let sort = 'no sotring'

tBody.addEventListener('click', e => {
  const id = e.target.getAttribute('data-id')

  if(!!id) {
    fetch('https://ab.tgiek.ru/php/getData/recordings.php', {
      method: 'delete',
      body: JSON.stringify({
        id: id, 
      })
    })
    e.target.parentNode.parentNode.style.display = 'none'
  }
})

date.addEventListener('change', e => {
  const target = e.target
  const filterDate = target.options[target.selectedIndex].textContent

  if(filterDate === 'Дата записи') {
    pagination.style.display = 'flex'
    getRecordings()
  }
  else{
    pagination.style.display = 'none'

    fetch('https://ab.tgiek.ru/php/getData/filterDates.php', {
      method: 'POST',
      body: JSON.stringify({
        filter: sort,
        date: filterDate
      })
    })
    .then(res => res.json())
    .then(res => {
      renderRecordings(res)  
    })
  }
})

const getRecordings = () => {
  const urlParams = new URLSearchParams(window.location.search);
  const page = parseInt(urlParams.get('page')) || 1
  const sort = urlParams.get('filter') || 'no sorting'

  fetch(`https://ab.tgiek.ru/php/getData/recordingsAdmin.php?page=${page}&filter=${sort}`)
  .then(res => res.json())
  .then(recordings => {
    renderRecordings(recordings.recordings)    
  })
}

const getDates = () => {
  fetch('https://ab.tgiek.ru/php/getData/dates.php')
  .then(res => res.json())
  .then(dates => {
    dates.forEach(el => date.innerHTML += `<option data-id='${el.id}' >${el.date}</option>` )
  })
}

const renderRecordings = data => {
  tBody.innerHTML = ``
  data.forEach(el => {
    tBody.innerHTML += `
      <tr class='recordings_row'>
        <td>${el.full_name}</th>
        <td>${el.phone}</td>
        <td>${el.email}</td>
        <td>${el.education}</td>
        <td>${el.type}</td>
        <td>${el.date}</td>
        <td>${el.time}</td>
        <td> <button class='btn btn-danger' id='delete' data-id='${el.id}'>&times;</button> </td>
      </tr>
    `
  })
}

getDates()
getRecordings()




//--- filter ---//
fio.addEventListener('click', () => {

  const urlParams = new URLSearchParams(window.location.search);
  let filter = urlParams.get('filter');
  const page = 1;

  switch(filter) {
    case 'no sorting':
      filter = 'fioUp'
      break
    case 'fioUp':
      filter = 'fioDown'
      break
    case 'fioDown':
      filter = 'no sorting'
      break
    default:
      filter = 'fioUp'
      break
  }
          
  window.history.replaceState(null, null, window.location.pathname);

  console.log(filter);
  urlParams.set('page', page);
  urlParams.set('filter', filter);
  urlParams.toString();
  document.location.search = urlParams;
})

// //--- filter-end ---//

pagination.addEventListener('click', e => {
  if(e.target.classList.contains('page-link')) {
    const page = e.target.getAttribute('data-page')
    
    const urlParams = new URLSearchParams(window.location.search);
    urlParams.set('page', page);
    urlParams.toString();
    document.location.search = urlParams;
  }
})

fetch('https://ab.tgiek.ru/php/getData/recordingsAdmin.php')
.then(res => res.json())
.then(({count}) => {

  const urlParams = new URLSearchParams(window.location.search);
  const page = parseInt(urlParams.get('page')) || 1

  pagination.innerHTML = `
    <li class="page-item ${page - 1 >= 1? '' : 'disabled'}">
      <a class="page-link" data-page="1">В начало</a>
    </li>
  `

  for(let i=page-2; i<=page+2; i++) {
    if(i >= 1 && i <= count+1) {
      pagination.innerHTML += `
      <li class="page-item ${page === i ? 'disabled' : ''}" aria-current="page">
        <a class="page-link" data-page="${i}"> ${i} </a>
      </li>
    `    
    }
  }

  pagination.innerHTML += `
    <li class="page-item ${page + 1 <= count+1? '' : 'disabled'}">
      <a class="page-link" data-page="${count+1}">В конец</a>
    </li>
  `
})


const urlParams = new URLSearchParams(window.location.search);
const filter = urlParams.get('filter') || 'no sorting'
switch(filter) {
  case 'no sorting':
    fio.innerHTML = 'ФИО'
    break
  case 'fioUp':
    // filter = 'fioDown'
    fio.innerHTML = 'ФИО <i class="fas fa-chevron-up"></i>'
    break
  case 'fioDown':
    fio.innerHTML = 'ФИО <i class="fas fa-chevron-down"></i>'
    break
  default:
    // filter = 'fioUp'
    break
}