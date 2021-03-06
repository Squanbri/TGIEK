const fio = document.querySelector('#FIO')
const phone = document.querySelector('#phone')
const email = document.querySelector('#email')
const education = document.querySelector('#education')
const selectType = document.querySelector('#selectType')
const selectDate = document.querySelector('#selectDate')
const selectTime = document.querySelector('#selectTime')

const preloader = document.querySelector('#preloader')

const btnRecord = document.querySelector('#record')

let dataRecords, dataDates, dataTimes
let selectUserDate
let ingoreList

const getData = async url => {
  const response = await fetch(`https://ab.tgiek.ru/php/getData/${url}.php`)
  const result = response.json()
  return result
}

function ignoreDate(records) {
  const calcDates = {}
  
  for(const record of records) {
    calcDates[record.date] = calcDates[record.date] + 1 || 1
  }

  const keys = Object.keys(calcDates).filter(key => calcDates[key] >= 48)

  selectUserDate = dataDates.find(el => !keys.includes(el.date)).date
  return keys
}

function ignoreTime(records) {
  const calcTimes = {}

  for(const record of records) {
    if(record.date === selectUserDate){
      calcTimes[record.time] = calcTimes[record.time] + 1 || 1
    }
  }

  const keys = Object.keys(calcTimes)
  return keys.filter(key => calcTimes[key] >= 4)
}

function changeDate() {
  console.log(1);
  selectUserDate = selectDate.options[selectDate.selectedIndex].value
  ignorList = ignoreTime(dataRecords)
  render(dataTimes, selectTime, 'time', ignorList)
}

const render = (data, html, title, ignore = []) => {
  html.innerHTML = ''
  data.forEach(el => {
    if( !ignore.includes(el[title]) )
      html.innerHTML += `<option data-id="${el.id}">${el[title]}</option>`
  })
}

const start = async () => {
  await getData('recordings').then(res => dataRecords = res)
  await getData('dates').then(res => dataDates = res)
  await getData('times').then(res => dataTimes = res)

  let ignoreDateList = await ignoreDate(dataRecords)
  let ignoreTimeList = await ignoreTime(dataRecords)
  
  await render(dataDates, selectDate, 'date', ignoreDateList)
  await render(dataTimes, selectTime, 'time', ignoreTimeList)

  preloader.style.display = 'none'
}

start()

selectDate.addEventListener('change', () => changeDate())
btnRecord.addEventListener('click', () => checkReg())


// RECORDING
const createRecording = () => {
  fetch('https://ab.tgiek.ru/php/getData/recordings.php', {
    method: 'post',
    body: JSON.stringify({
      type: selectType.value, 
      date: selectDate.value,
      time: selectTime.value,
      full_name: fio.value,
      email: email.value,
      education: education.value,
      phone: phone.value,
    })
  })

}

// ---------
// SEND MAIL
function sendMail() {
  fetch('https://ab.tgiek.ru/php/sendEmail.php', {
    method: 'post',
    body: JSON.stringify({
      type: selectType.value, 
      date: selectDate.value,
      time: selectTime.value,
      education: education.value,
      full_name: fio.value,
      email: email.value,
      education: education.value,
    })
  })  
}

function checkReg() {
  //-- START ???????????????? ???? ?????????????????? ???????????????????? ??????????
  empty = ['#FIO', '#phone', '#email', '#education', '#selectType', '#selectDate', '#selectTime']
  empty.forEach(el => {
    document.querySelector(el).classList.remove('is-invalid')
  })

  const fio = document.querySelector('#FIO').value
  const phone = document.querySelector('#phone').value
  const email = document.querySelector('#email').value
  const type = document.querySelector('#selectType').value
  const date = document.querySelector('#selectDate').value
  const time = document.querySelector('#selectTime').value

  empty = []
  if(!fio || !/\S[??-????-?? ]/.test(fio)) empty.push('#FIO')
  if(!phone) empty.push('#phone')
  if(!email || !/\S+@\S+\.\S+/.test(email)) empty.push('#email')
  if(!type) empty.push('#selectType')
  if(!date) empty.push('#selectDate')
  if(!time) empty.push('#selectTime')

  empty.forEach(el => {
    document.querySelector(el).classList.add('is-invalid')
  })
  //-- END ???????????????? ???? ?????????????????? ???????????????????? ??????????


  if(empty.length === 0) { // ???????? ?????? ???????????????????? ????????????????
    fetch('https://ab.tgiek.ru/php/getData/checkEmail.php', {
      method: 'post',
      body: JSON.stringify({
        fio: fio,
        email: email,
      })
    })
    .then(res => res.json())
    .then(res => {
      if (res.length === 0) { // ???????? ?????????? email ???? ??????????????????????????????
        createRecording()
        sendMail()

        modalShow()
      }
      else {
        modalFail()
      }
    })
  }
  return empty.length === 0
}


// MASK ON PHONE INPUT
$("#phone").mask("+7(999)999-99-99");

function modalShow() {
  $('.modal-content').html(`
    <div class="modal-header">
      <h5 class="modal-title">???? ???????????????????????????????? ????????????</h5>
    </div>
    <div class="modal-body">
      <p>???????????? ???????????????????? ???? ??????????. <br>???????? ???????????? ???? ????????????, ?????????????????? ?????????? "C??????".</p>
    </div>
    <div class="modal-footer">
      <button type="button" class="modal-close-footer" id="modal-close-2" data-bs-dismiss="modal">??????????????</button>
    </div>
  `)

  $('#modal').modal('show');
  
  $('.modal-close-footer').on('click', () => location.reload() )
}

function modalFail() {
  const fio = document.querySelector('#FIO').value
  const email = document.querySelector('#email').value

  $('.modal-content').html(`
    <div class="modal-header">
      <h5 class="modal-title">???? ?????????????? ????????????????????</h5>
    </div>
    <div class="modal-body">
      <p>???????????? ???? ?????? <b>${fio}</b> ?? ???????????? <b>${email}</b> ?????? ????????????????????????????????</p>
    </div>
    <div class="modal-footer">
      <button type="button" class="modal-close-footer" id="modal-close-2" data-bs-dismiss="modal">??????????????</button>
    </div>
  `)

  $('#modal').modal('show');
  
  $('.modal-close-footer').on('click', () => location.reload() )
}