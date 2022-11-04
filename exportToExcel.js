function exportToExcel(tableId){
	let tableData = document.getElementById(tableId).outerHTML;

	let a = document.createElement('a');
	a.href = `data:application/vnd.ms-excel, ${encodeURIComponent(tableData)}`
	a.download = 'downloaded_file_' + getRandomNumbers() + '.csv'
	a.click()
}
function getRandomNumbers() {
	let dateObj = new Date()
	let dateTime = `${dateObj.getHours()}${dateObj.getMinutes()}${dateObj.getSeconds()}`

	return `${dateTime}${Math.floor((Math.random().toFixed(2)*100))}`
}
