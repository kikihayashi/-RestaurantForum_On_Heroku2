// var action = false;

// class BaseCharacter {
//   constructor(hp, maxHp, atk) {
//     this.hp = hp;
//     this.maxHp = maxHp;
//     this.atk = atk;
//   }

//   attack(tag, times) {
//     var _this = document.getElementById(tag);
//     var i = 0;

//     var attack_interval = setInterval(function () {
//       if (i == 1) {
//         _this.getElementsByClassName("effect-image")[0].style.display = "block";
//         _this.getElementsByClassName("hurt-text")[0].classList.add("attacked");
//       }

//       if (i >= 1) {

//         var picName = (times == 1) ? "effect" : "effect2";

//         _this.getElementsByClassName("effect-image")[0].src = 'images/' + picName + '/blade/' + i + '.png';
//       }

//       if (i >= 8) {
//         _this.getElementsByClassName("effect-image")[0].style.display = "none";
//         _this.getElementsByClassName("hurt-text")[0].classList.remove("attacked");
//         clearInterval(attack_interval);
//         if (tag == "hero-image-block") {
//           document.getElementById("skill-row").style.display = 'block';
//         }
//       }
//       i++;
//     }, 140);
//   }
// }

// class Hero extends BaseCharacter {
//   constructor(hp, maxHp, atk) {
//     //只要繼承都需要先super
//     super(hp, maxHp, atk);
//     this.element = document.getElementById("hero-image-block");
//     console.log("召喚英雄！");
//   }

//   attack(times) {
//     roleMove(this);
//     super.attack("monster-image-block", times);

//     setTimeout(function () {
//       var filterId = "#monster-image-block > div.character-block > span.hurt-text";
//       document.querySelector(filterId).innerHTML = hero.atk * -1 * times;
//       document.querySelector(filterId).style.color = "red";
//       document.querySelector(filterId).transition = "bottom 3000ms";
//       setValueById("monster-hp", monster.hp - hero.atk * times);
//       setTimeout(function () {
//         document.querySelector(filterId).innerHTML = "";
//       }, 500);
//     }, 800);
//     monsterAttack();
//   }

//   heal() {
//     setTimeout(function () {
//       var i = 1;
//       var healeffect = setInterval(function () {
//         document.getElementsByClassName("hurt-text")[0].classList.add("attacked");
//         document.getElementsByClassName("effect-image")[0].style.display = "block";
//         document.getElementsByClassName("effect-image")[0].src = 'images/effect1/blade/' + i + '.png';
//         i++;

//         if (i == 8) {
//           clearInterval(healeffect);
//           document.getElementsByClassName("effect-image")[0].style.display = "none";
//         }
//       }, 140);
//     }, 250);

//     setTimeout(function () {
//       var filterId = "#hero-image-block > div.character-block > span.hurt-text";
//       document.querySelector(filterId).innerHTML = "+" + hero.atk * 1.5;
//       document.querySelector(filterId).style.color = "green";
//       document.querySelector(filterId).transition = "bottom 3000ms";
//       setValueById("hero-hp", hero.hp + hero.atk * 1.5);
//       setTimeout(function () {
//         document.querySelector(filterId).innerHTML = "";
//         document.getElementsByClassName("hurt-text")[0].classList.remove("attacked");
//       }, 500);
//     }, 800);
//     monsterAttack();
//   }
// }

// class Monster extends BaseCharacter {
//   constructor(hp, maxHp, atk) {
//     //只要繼承都需要先super
//     super(hp, maxHp, atk);
//     this.element = document.getElementById("monster-image-block");
//     console.log("召喚怪物！");
//   }

//   attack() {
//     super.attack("hero-image-block", 1);
//   }
// }

// var rounds = 10;
// var hero = new Hero(130, 130, 40);
// var monster = new Monster(130, 130, 30);

// function roleMove(role) {
//   setTimeout(function () {
//     role.element.classList.add("attacking");
//     setTimeout(function () {
//       role.element.classList.remove("attacking");
//     }, 500);
//   }, 100);
// }

// function monsterAttack() {
//   var filterId = "#hero-image-block > div.character-block > span.hurt-text";
//   setTimeout(function () {
//     if (checkWhoWin()) {
//       roleMove(monster);
//       setTimeout(function () {
//         monster.attack(hero);
//         setTimeout(function () {
//           document.querySelector(filterId).innerHTML = monster.atk * -1;
//           document.querySelector(filterId).style.color = "red";
//           document.querySelector(filterId).transition = "bottom 3000ms";
//           setValueById("hero-hp", hero.hp - monster.atk);
//           setTimeout(function () {
//             document.querySelector(filterId).innerHTML = "";
//           }, 500);
//           setTimeout(function () {
//             gameResult();
//           }, 400);
//         }, 800);
//       }, 500);
//     }
//   }, 1500);
// }

// function gameResult() {
//   rounds--;
//   document.getElementById("round-num").innerHTML = rounds;
//   checkWhoWin();
// }

// function checkWhoWin() {
//   if (hero.hp <= 0 || monster.hp <= 0) {
//     showWinner();
//     return false;
//   }
//   if (rounds == 0) {
//     showWinner();
//     return false;
//   }
//   return true;
// }

// function showWinner() {
//   var whoWin = (hero.hp > monster.hp) ? "Hero" : "Monster";
//   var result = confirm("遊戲結束：" + whoWin + "贏了！");
//   if (result) {
//     history.go(0);
//   }
// }

function editContent() {
  var value = confirm('確定要刪除？');
  if (value == true) {


  } else {

  }
}

// function setValueById(id, value) {
//   switch (id) {
//     case "hero-hp":
//       hero.hp = value;
//       break;
//     case "hero-max-hp":
//       hero.maxHp = value;
//       break;
//     case "hero-atk":
//       hero.atk = value;
//       break;
//     case "monster-hp":
//       monster.hp = value;
//       break;
//     case "monster-max-hp":
//       monster.maxHp = value;
//       break;
//     case "monster-atk":
//       monster.atk = value;
//       break;
//   }

//   document.getElementById(id).innerHTML = value;

//   var heroPercent = hero.hp / hero.maxHp * 95;
//   var monsterPercent = monster.hp / monster.maxHp * 95;

//   if (heroPercent > 100) {
//     heroPercent = 95;
//   }
//   if (heroPercent < 0) {
//     heroPercent = 0;
//   }
//   if (monsterPercent > 100) {
//     monsterPercent = 95;
//   }
//   if (monsterPercent < 0) {
//     monsterPercent = 0;
//   }
//   document.getElementsByClassName("hero-hp-bar")[0].style.width = heroPercent + '%';
//   document.getElementsByClassName("monster-hp-bar")[0].style.width = monsterPercent + '%';
// }

// function heroAction(action) {
//   document.getElementById("skill-row").style.display = 'none';
//   switch (action) {
//     case 'Attack':
//       hero.attack(1);
//       break;
//     case 'Trick':
//       hero.attack(2);
//       break;
//     case 'Heal':
//       hero.heal();
//       break;
//   }
// }

// document.addEventListener("DOMContentLoaded", function (event) {
//   document.getElementById("round-num").innerHTML = rounds;
//   document.getElementById("hero-hp").innerHTML = hero.hp;
//   document.getElementById("hero-max-hp").innerHTML = hero.maxHp;
//   document.getElementById("hero-atk").innerHTML = hero.atk;
//   document.getElementById("monster-hp").innerHTML = monster.hp;
//   document.getElementById("monster-max-hp").innerHTML = monster.maxHp;
//   document.getElementById("monster-atk").innerHTML = monster.atk;
//   document.onkeyup = function (event) {
//     if (document.getElementById("skill-row").style.display != 'none') {
//       var key = String.fromCharCode(event.keyCode);
//       if (key == "A") {
//         heroAction('Attack');
//       }
//       if (key == "S") {
//         heroAction("Trick");
//       }
//       if (key == "D") {
//         heroAction("Heal");
//       }
//     }
//   }
// });