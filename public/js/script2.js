/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/modules/getState.js":
/*!*********************************!*\
  !*** ./src/modules/getState.js ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _renderOffers__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./renderOffers */ "./src/modules/renderOffers.js");


const getState = (state) => {

    axios.get('/get/getSubcrList').then(res => {
        state.offerList = res.data;
        console.log('state.offerList', state.offerList);
       })
       .then(() => {
            console.log('Загрузка данных выполнена!');
            (0,_renderOffers__WEBPACK_IMPORTED_MODULE_0__["default"])(state);
        })
        .catch(function(error) {
            console.log("Ошибка " + error);
     });
     

};

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (getState);

/***/ }),

/***/ "./src/modules/makeGraf.js":
/*!*********************************!*\
  !*** ./src/modules/makeGraf.js ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
const makeGraf = (state, name1, name2) => {

    const ctx = document.getElementById('myChart');
    const btnYear = document.getElementById("graf1");
    const btnMonth = document.getElementById("graf2");
    const btnDay = document.getElementById("graf3");
    const summaryGraf = document.querySelector(".grafTag");
    let chartStatus;
  
    changeGraf();
    getYearGrafFromDB();
  
      function changeGraf() {
          btnYear.addEventListener( "click", getYearGrafFromDB);    
          btnMonth.addEventListener( "click", getMonthGrafFromDB);    
          btnDay.addEventListener( "click", getDayGrafFromDB);    
      }
  
      function updateTextSummary() {
          summaryGraf.textContent = 'Итого за период: переходы - '+ state.sum + ', доход - ' + state.total + ' руб';
      }
  
      function getYearGrafFromDB() {
          state.sum = 0;
          state.total = 0;
          axios.get('/get/getYearGrafSubcr').then(res => {
                  state.yearData1 = res.data.map(item => {
                      state.total += Number(item['total']);    
                      return item['total'] === null ? 0 : item['total'];
                  });
                  state.yearData2 = res.data.map(item => {
                      state.sum += Number(item['sum']);
                      return item['sum'] === null ? 0 : item['sum'];
                  });
                  console.log('state.yearData1', state.yearData1);
                  console.log('state.yearData2', state.yearData2);
                }) 
                .then(() => {
                  console.log('Загрузка графика выполнена!');
                  updateTextSummary();
                  yearGraf();
              })
              .catch(function(error) {
              console.log("Ошибка базы данных " + error);
          });
      } 
  
      function getMonthGrafFromDB() {
          state.sum = 0;
          state.total = 0;
          axios.get('/get/getMonthGrafSubcr').then(res => {
                  state.monthData1 = res.data.map(item => {
                      state.total += Number(item['total']);    
                      return item['total'] === null ? 0 : item['total'];
                  });
                  state.monthData2 = res.data.map(item => {
                      state.sum += Number(item['sum']);
                      return item['sum'] === null ? 0 : item['sum'];
                  });
                  console.log('state.monthData1', state.monthData1);
                  console.log('state.monthData2', state.monthData2);
                }) 
                .then(() => {
                  console.log('Загрузка графика выполнена!');
                  updateTextSummary();
                  monthGraf();
              })
              .catch(function(error) {
              console.log("Ошибка базы данных " + error);
          });
      } 
  
      function getDayGrafFromDB() {
          state.sum = 0;
          state.total = 0;
          axios.get('/get/getDayGrafSubcr').then(res => {
                  state.dayData1 = res.data.map(item => {
                      state.total += Number(item['total']);    
                      return item['total'] === null ? 0 : item['total'];
                  });
                  state.dayData2 = res.data.map(item => {
                      state.sum += Number(item['sum']);
                      return item['sum'] === null ? 0 : item['sum'];
                  });
                  console.log('state.dayData1', state.dayData1);
                  console.log('state.dayData2', state.dayData2);
                }) 
                .then(() => {
                  console.log('Загрузка графика выполнена!');
                  updateTextSummary();
                  dayGraf();
              })
              .catch(function(error) {
              console.log("Ошибка базы данных " + error);
          });
      } 
  
      function yearGraf() {
          initGraf(state.yearLabels, name1, name2, state.yearData1, state.yearData2);
      }
  
      function monthGraf() {
          initGraf(state.monthLabels, name1, name2, state.monthData1, state.monthData2);
      }
  
      function dayGraf() {
          initGraf(state.dayLabels, name1, name2, state.dayData1, state.dayData2);
      }
  
      function initGraf(labels, name1, name2, data1, data2) {
          if (chartStatus != undefined) {
              chartStatus.destroy();
            }
          chartStatus = new Chart(ctx, {
              type: 'bar',
              data: {
              labels: labels,
              datasets: [{
                  label: name1,
                  data: data1,
                  borderWidth: 1,
                  backgroundColor: 'rgba(255, 99, 132, 0.2)',
                  borderColor: 'rgba(255,99,132,1)',
              }, {
                  label: name2,
                  data: data2,
                  borderWidth: 1,
                  backgroundColor: 'rgba(54, 162, 235, 0.2)',
                  borderColor: 'rgba(54, 162, 235, 1)',
              }],
              options: {
              scales: {
                  y: {
                      beginAtZero: true
                  }
                  }
              }
              }
          });
      }
  
  
  };  

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (makeGraf);

/***/ }),

/***/ "./src/modules/renderOffers.js":
/*!*************************************!*\
  !*** ./src/modules/renderOffers.js ***!
  \*************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
const renderOffers = (state) => {

    const divTable =  document.getElementById('offers');
    const filterAll =  document.getElementById('offer_all');
    const filterSelect =  document.getElementById('offer_select');
    let filterSelectOn = false;
    const mainContainer = document.querySelector(".container"); 
    const windowAddOffer = document.querySelector(".layerAddOffer2");
    
    const btnReset = document.querySelector("#reset");
    let shadowOverlay;
    let codeURL = '';

    setHandler();
    offerTableListener();
    renderTableOffers();
    

    function setHandler() {
        //document.addEventListener( "click", function(e) {
        //    console.log(e.target);
        //});     
        filterAll.addEventListener( "click", function(e) {
            if (filterSelectOn) {
                filterSelectOn = false;
                renderTableOffers();  
            }
        });     
        filterSelect.addEventListener( "click", function(e) {
            if (!filterSelectOn) { 
                filterSelectOn = true;
                renderTableOffers(state.offerList.filter(arr => arr['status'] == 1));  
            }
        });    
        btnReset.addEventListener( "click", closeOverlay);    

    }

    function renderTableOffers(arr=state.offerList) {
        divTable.innerHTML = '';
        arr.forEach(offer => {
                let classTable = offer['status'] == 1 ? 'table-success' : 'table-primary';
                let classButton = offer['status'] == 1 ? '' : 'disabled';
                divTable.innerHTML += `
                                <tr class=${classTable} data-id=${offer['id']}>
                                    <td>${offer['name']}</td>
                                    <td>${(offer['price']*0.8).toFixed(2)}</td>
                                    <td>${offer['url']}</td>
                                    <td>${offer['keywords']}</td>
                                    <td><a type="button" href="#" class="btn btn-info ${classButton}" id="keyUrl">Cсылка</a></td>
                                </tr>`;
        });
            
    }

    function setStatusOffer(id, status) {
        state.offerList.forEach(arr => {
            if (arr.id == id) {
                setStatusSubcrInDB(id, arr.status);
                arr.status = status;
            }
        });
        if ((filterSelectOn) && (!status)) { 
            renderOffers(state.offerList.filter(arr => arr['status'] == 1));  
        }
    }

    function setStatusSubcrInDB(id, old_status) {
        axios({
          method: 'post',
          url: '/post/setStatusSubcrInDB',
          headers: {
          "Content-type": "application/json; charset=UTF-8"
        },
          data:  {"id": id, "status": old_status}
          })
          .then(() => {
              console.log('Статус оффера успешно обновлен.');
          })
          .catch(function(error) {
              console.log(error);
          });
    }

    function addEventLinkInDB(id) {
        axios({
          method: 'post',
          url: '/post/addEventLink',
          headers: {
          "Content-type": "application/json; charset=UTF-8"
        },
          data:  {"id": id}
          })
          .then(() => {
              console.log('Лог обновлен.');
          })
          .catch(function(error) {
              console.log(error);
          });
    }

    function getReferalURL(id) {
        axios({
            method: 'post',
            url: '/post/getCurrentOrder',
            headers: {
            "Content-type": "application/json; charset=UTF-8"
          },
          data:  {"offer_id": id}
        })
           .then(res => {
            state.url = res.data;
            console.log('state.url', res.data);
           })
           .then(() => {
                    console.log('Данные для урл получены!');
                    codeURL = '<h3>Код ссылки для вставки на сайт -<br/><b>http://' + window.location.hostname + '/ref=' + state.url[0]['master_id'] + ',off=' + state.url[0]['offer_id'] + '</b></h3>';
                    document.querySelector('#insertCode').innerHTML = codeURL;
            })
            .then(() => {
                addEventLinkInDB(id);
            })
            .catch(function(error) {
                console.log("Ошибка " + error);
                codeURL = `<h3>Данный оффер уже недействителен, обновите страницу</h3>`;
                document.querySelector('#insertCode').innerHTML = codeURL;
         });
    }

    function toggleClassTable(id, confirmText, e = null) {
        const selector = "[data-id=" + '"' + id + '"]'; 
        const elemTable = document.querySelector(selector);
        if ((e.target.classList.contains('btn')) && (!e.target.classList.contains('disabled'))) {
            // get from database code
            getReferalURL(id); 
            initOverlay();
        } else {
                if (elemTable.classList.contains('table-success')) {
                    if (confirm(confirmText)) {
                        let keyClass = elemTable.querySelector('#keyUrl');
                        keyClass.classList.toggle('disabled');
                        elemTable.classList.toggle('table-success');
                        elemTable.classList.toggle('table-primary');
                        setStatusOffer(id, null);
                    }
                } else {
                        let keyClass = elemTable.querySelector('#keyUrl');
                        keyClass.classList.toggle('disabled');
                        elemTable.classList.toggle('table-success');
                        elemTable.classList.toggle('table-primary');
                        setStatusOffer(id, 1);
                }
        }
    }

    function offerTableListener() {
        divTable.addEventListener( "click", function(e) {
            toggleClassTable(getIdOnClick(e), "Вы действительно хотите деактивировать оффер?", e);
        });     
    }
  
    function getIdOnClick(e) { 
        let node = e.target;
        let id;
        do {
            hasAttr(node, "data-id") ? id = node.getAttribute("data-id") : node = node.parentNode;
        } while (!id);
        return id;
    }
    
    function hasAttr(element, attr) {
        if(typeof element === 'object' && element !== null && 'getAttribute' in element  && element.hasAttribute(attr)) {
          return true;
        } else {
          return false;
        }
    }

    function listener1(e) {
        if (e.target.classList.contains('overlay__shadow')) {
            closeOverlay();
        }
      }

    function listener2(e) {
        if (e.key === 'Escape') {
            closeOverlay();
        }
      }
     
    function initOverlay() { 
            shadowOverlay = document.createElement('div');
            shadowOverlay.classList.add('overlay__shadow');
            shadowOverlay.classList.add('overlay__shadow--show');
            shadowOverlay.addEventListener('click', listener1);
            window.addEventListener('keydown', listener2);
            mainContainer.appendChild(shadowOverlay);
            windowAddOffer.classList.add('active');
      }
      
      function closeOverlay() {
            shadowOverlay.removeEventListener('click', listener1, false);
            window.removeEventListener('keydown', listener2, false);
            shadowOverlay.classList.remove('overlay__shadow--show');
            shadowOverlay.classList.remove('overlay__shadow');
            mainContainer.removeChild(shadowOverlay);
            windowAddOffer.classList.remove('active');
      }
    

};

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (renderOffers);

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!*********************!*\
  !*** ./src/main.js ***!
  \*********************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _modules_getState__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./modules/getState */ "./src/modules/getState.js");
/* harmony import */ var _modules_makeGraf__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./modules/makeGraf */ "./src/modules/makeGraf.js");



window.addEventListener('DOMContentLoaded', () => {

   let state = {
    offerList: [],
    yearLabels: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
    monthLabels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'],
    dayLabels: ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23'],
    yearData1: [],
    yearData2: [],
    monthData1: [],
    monthData2: [],
    dayData1: [],
    dayhData2: []
   }; 

  (0,_modules_getState__WEBPACK_IMPORTED_MODULE_0__["default"])(state);  
  (0,_modules_makeGraf__WEBPACK_IMPORTED_MODULE_1__["default"])(state, 'Доходы, руб', 'Переходы, клик');
   

});


})();

/******/ })()
;
//# sourceMappingURL=script2.js.map