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
/* harmony import */ var _renderUsers__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./renderUsers */ "./src/modules/renderUsers.js");


async function getState(state) {

    await axios.get('/get/getUserList').then(res => {
         state.userList = res.data;
         console.log('state.userList', state.userList);
        })
        .then(() => {
            console.log('Загрузка данных выполнена!');
            (0,_renderUsers__WEBPACK_IMPORTED_MODULE_0__["default"])(state);
       })   
        .catch(function(error) {
         console.log("Ошибка базы данных " + error);
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
        summaryGraf.textContent = 'Итого за период: доходы - ' + state.total.toFixed(2) + ' руб, переходы - '+ state.sum + ', отказы - ' + state.reject + ', выданные ссылки - ' + state.links ;
    }

    function getCountLinksYear() {
        axios.get('/get/countLinksYear').then(res => {
            state.links = res.data;
            console.log(state.links);
        })
            .catch(function(error) {
            console.log("Ошибка базы данных " + error);
         });
    }

    function getRejectYear() {
        axios.get('/get/countRejectYear').then(res => {
            state.reject = res.data;
            console.log(state.reject);
        })
        .then(() => {
            updateTextSummary();
        })
            .catch(function(error) {
            console.log("Ошибка базы данных " + error);
         });
    }

    function getCountLinksMonth() {
        axios.get('/get/countLinksMonth').then(res => {
            state.links = res.data;
            console.log(state.links);
        })
            .catch(function(error) {
            console.log("Ошибка базы данных " + error);
         });
    }

    function getRejectMonth() {
        axios.get('/get/countRejectMonth').then(res => {
            state.reject = res.data;
            console.log(state.reject);
        })
        .then(() => {
            updateTextSummary();
        })
            .catch(function(error) {
            console.log("Ошибка базы данных " + error);
         });
    }

    function getCountLinksDay() {
        axios.get('/get/countLinksDay').then(res => {
            state.links = res.data;
            console.log(state.links);
        })
            .catch(function(error) {
            console.log("Ошибка базы данных " + error);
         });
    }

    function getRejectDay() {
        axios.get('/get/countRejectDay').then(res => {
            state.reject = res.data;
            console.log(state.reject);
        })
        .then(() => {
            updateTextSummary();
        })
            .catch(function(error) {
            console.log("Ошибка базы данных " + error);
         });
    }

    function getYearGrafFromDB() {
        state.sum = 0;
        state.total = 0;
        axios.get('/get/getYearGrafAdmin').then(res => {
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
            }) .then(() => {
                getCountLinksYear();
                getRejectYear();
            }) .then(() => {
                console.log('Загрузка графика выполнена!');
               // updateTextSummary();
                yearGraf();
            })
            .catch(function(error) {
            console.log("Ошибка базы данных " + error);
        });
    } 

    function getMonthGrafFromDB() {
        state.sum = 0;
        state.total = 0;
        axios.get('/get/getMonthGrafAdmin').then(res => {
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
            }) .then(() => {
                getCountLinksMonth();
                getRejectMonth();
            }) .then(() => {
                console.log('Загрузка графика выполнена!');
                // updateTextSummary();
                monthGraf();
            })
            .catch(function(error) {
            console.log("Ошибка базы данных " + error);
        });
    } 

    function getDayGrafFromDB() {
        state.sum = 0;
        state.total = 0;
        axios.get('/get/getDayGrafAdmin').then(res => {
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
            }) .then(() => {
                getCountLinksDay();
                getRejectDay();
            }) .then(() => {
                console.log('Загрузка графика выполнена!');
                // updateTextSummary();
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

/***/ "./src/modules/renderUsers.js":
/*!************************************!*\
  !*** ./src/modules/renderUsers.js ***!
  \************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
const renderUsers = (state) => {

    const divTable =  document.getElementById('offers');
    const filterAll =  document.getElementById('offer_all');
    const filterSelect =  document.getElementById('offer_select');
    let filterSelectOn = false;
    
    const btnRefresh = document.querySelector("#refresh");

    setHandler();
    userTableListener();
    renderTableUsers();

    function setHandler() {
        // Debug test listener
        //document.addEventListener( "click", function(e) {
        //    console.log(e.target);
        //});     
        filterAll.addEventListener( "click", function(e) {
            if (filterSelectOn) {
                filterSelectOn = false;
                renderTableUsers();  
            }
        });     
        filterSelect.addEventListener( "click", function(e) {
            if (!filterSelectOn) { 
                filterSelectOn = true;
                renderTableUsers(state.userList.filter(arr => arr['roles_mask'] == 0));  
            }
        });    
        btnRefresh.addEventListener( "click", getUsersFromDB);    
    }
 
    function getUsersFromDB() {
        axios.get('/get/getUserList').then(res => {
            state.userList = res.data;
            console.log('state.userList', state.userList);
           })
           .then(() => {
               console.log('Загрузка данных выполнена!');
               renderTableUsers();
          })   
           .catch(function(error) {
            console.log("Ошибка базы данных " + error);
         });
    }   

    function renderTableUsers(arr=state.userList) {
        divTable.innerHTML = '';
        if (arr.length != 0) {
            arr.forEach(user => {
                let classTable = user['roles_mask'] == 163856 ? 'table-success' : user['roles_mask'] == 131090 ? 'table-primary' : 'table-danger';
                let nameRole = user['roles_mask'] == 163856 ? 'Заказчик' : user['roles_mask'] == 131090 ? 'Веб-мастер' : 'Не определен';
                divTable.innerHTML += `
                                <tr class=${classTable} data-id=${user['id']}>
                                    <td>${user['username']}</td>
                                    <td>${user['email']}</td>
                                    <td id="role">${nameRole}</td>
                                </tr>`;
                        });
        }
    }

    function changeRole(id, selector, status) { 
        const subselector = selector.querySelector("#role");
        state.userList.forEach(arr => {
            if (arr.id == id) {
                if (status) {
                    if (arr['roles_mask'] === 0) {
                        arr['roles_mask'] =  131090;   
                    } else {
                        if (arr['roles_mask'] === 131090) {
                            arr['roles_mask'] = 163856;   
                        } else {
                            arr['roles_mask'] = 131090;   
                        }   
                    }
                } else {
                    arr['roles_mask'] = 0;  
                }
                setRoleInDB(id, arr['roles_mask']);
                switch (arr['roles_mask']) {
                    case 0:
                        selector.classList.add('table-danger');
                        selector.classList.remove('table-success');
                        selector.classList.remove('table-primary');   
                        subselector.textContent = 'Не определен';
                        break;
                    case 163856:
                        selector.classList.toggle('table-success');
                        selector.classList.toggle('table-primary');
                        subselector.textContent = 'Заказчик';
                        break;
                    case 131090:
                        selector.classList.add('table-primary');   
                        selector.classList.remove('table-danger');
                        selector.classList.remove('table-success');
                        subselector.textContent = 'Веб-мастер';
                        break;
                }              
            }
        });
        if (filterSelectOn) { 
            renderTableUsers(state.userList.filter(arr => arr['roles_mask'] == 0));  
        }
    }

    function setRoleInDB(id, role) {
        axios({
          method: 'post',
          url: '/post/setRoleInDB',
          headers: {
          "Content-type": "application/json; charset=UTF-8"
        },
          data:  {"id": id, "roles_mask": role}
          })
          .then(() => {
              console.log('Роль пользователя успешно обновлен.');
          })
          .catch(function(error) {
              console.log(error);
          });
    }
    
    function toggleClassTable(id, confirmText) {
        const selector = "[data-id=" + '"' + id + '"]'; 
        const elemTable = document.querySelector(selector);
        if (confirm(confirmText)) { 
            confirmText === 'Изменить роль?' ? changeRole(id, elemTable, true) : changeRole(id, elemTable, false);
        } 
    }

    function userTableListener() {
        divTable.addEventListener( "click", function(e) {
          toggleClassTable(getIdOnClick(e), "Изменить роль?");
        });   
        divTable.addEventListener('contextmenu', function(e)  {
            e.preventDefault();
            toggleClassTable(getIdOnClick(e), "Отменить роль?");  
        })
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
    

};

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (renderUsers);

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
    userList: [],
    yearLabels: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
    monthLabels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'],
    dayLabels: ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23']
   }; 

  (0,_modules_getState__WEBPACK_IMPORTED_MODULE_0__["default"])(state);
  
  (0,_modules_makeGraf__WEBPACK_IMPORTED_MODULE_1__["default"])(state, 'Доходы, руб', 'Переходы, клик');
   
});


})();

/******/ })()
;
//# sourceMappingURL=script3.js.map