
let userPts = 1250;
let currentItem = null;

const SHOP_ITEMS = [
  { id:1, emoji:'☕', name:'Café Voucher', category:'Food & Drink', desc:'RM5 off at APU Café. Valid for 30 days.', cost:200, tag:'hot' },
  { id:2, emoji:'🧃', name:'Juice Bar Credit', category:'Food & Drink', desc:'Free smoothie or fresh juice of your choice.', cost:350, tag:'new' },
  { id:3, emoji:'📓', name:'Eco Notebook', category:'Stationery', desc:'Recycled paper notebook with EcoPoints branding.', cost:150, tag:null },
  { id:4, emoji:'🖊️', name:'Bamboo Pen Set', category:'Stationery', desc:'Set of 3 sustainable bamboo ballpoint pens.', cost:120, tag:null },
  { id:5, emoji:'👕', name:'EcoPoints Tee', category:'Merchandise', desc:'Limited edition organic cotton t-shirt. Sizes S–XL.', cost:1200, tag:'rare' },
  { id:6, emoji:'🧢', name:'Green Campus Cap', category:'Merchandise', desc:'Embroidered cap. Flex on the planet-destroyers.', cost:800, tag:null },
  { id:7, emoji:'🎟️', name:'Event Priority Pass', category:'Events', desc:'Skip the queue at APU sustainability events.', cost:500, tag:'new' },
  { id:8, emoji:'🛍️', name:'Campus Store Voucher', category:'Vouchers', desc:'RM10 credit at the APU campus store.', cost:400, tag:null },
  { id:9, emoji:'🌱', name:'Plant a Tree', category:'Events', desc:'Sponsor a tree planting in your name on campus.', cost:2000, tag:'rare' },
];

function goToPage(pageId) {
  document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
  document.getElementById(pageId).classList.add('active');
  window.scrollTo(0, 0);
  if (pageId === 'page-shop') renderShop(SHOP_ITEMS);
}


function switchTab(tab) {
  document.querySelectorAll('.login-tab').forEach((t, i) => {
    t.classList.toggle('active', (i === 0 && tab === 'login') || (i === 1 && tab === 'signup'));
  });
  document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
  document.getElementById('tab-' + tab).classList.add('active');
}

function doLogin() {
  const tp = document.getElementById('tp-input').value.trim();
  const pw = document.getElementById('pw-input').value.trim();
  if (!tp || !pw) { showNotif('Please enter your TP number and password.', 'error'); return; }
  showNotif('Authenticating...', '');
  setTimeout(() => {
    showNotif('Login successful. Welcome back!', 'success');
    setTimeout(() => goToPage('page-shop'), 800);
  }, 800);
}


function renderShop(items) {
  const grid = document.getElementById('shop-grid');
  grid.innerHTML = '';
  items.forEach(item => {
    const canAfford = userPts >= item.cost;
    const div = document.createElement('div');
    div.className = 'shop-item' + (canAfford ? ' affordable' : ' cant-afford');
    div.innerHTML =
      '<div class="item-img">' +
        item.emoji +
        (item.tag ? '<div class="item-tag ' + item.tag + '">' + item.tag.toUpperCase() + '</div>' : '') +
      '</div>' +
      '<div class="item-info">' +
        '<div class="item-category">// ' + item.category + '</div>' +
        '<div class="item-name">' + item.name + '</div>' +
        '<div class="item-desc">' + item.desc + '</div>' +
        '<div class="item-footer">' +
          '<div class="item-cost">' + item.cost.toLocaleString() + ' <span>PTS</span></div>' +
          '<button class="redeem-btn ' + (canAfford ? 'affordable' : '') + '" onclick="openModal(' + item.id + ')">' + (canAfford ? '>> REDEEM' : 'LOCKED') + '</button>' +
        '</div>' +
      '</div>';
    grid.appendChild(div);
  });
}

function filterShop(query) {
  const q = query.toLowerCase();
  const filtered = SHOP_ITEMS.filter(i =>
    i.name.toLowerCase().includes(q) ||
    i.category.toLowerCase().includes(q) ||
    i.desc.toLowerCase().includes(q)
  );
  renderShop(filtered);
}

function updateFilter() {
  showNotif('Filters applied.', '');
}


function openModal(itemId) {
  currentItem = SHOP_ITEMS.find(i => i.id === itemId);
  if (!currentItem || userPts < currentItem.cost) {
    showNotif('Not enough EcoPoints to redeem this item.', 'error');
    return;
  }
  document.getElementById('modal-emoji').textContent = currentItem.emoji;
  document.getElementById('modal-name').textContent = currentItem.name;
  document.getElementById('modal-desc').textContent = currentItem.desc;
  document.getElementById('modal-cost').textContent = currentItem.cost.toLocaleString() + ' PTS';
  document.getElementById('modal-balance').textContent = 'BALANCE AFTER: ' + (userPts - currentItem.cost).toLocaleString() + ' PTS';
  document.getElementById('item-modal').classList.add('open');
}

function closeModal() {
  document.getElementById('item-modal').classList.remove('open');
  currentItem = null;
}

function confirmRedeem() {
  if (!currentItem) return;
  userPts -= currentItem.cost;
  document.getElementById('header-pts').textContent = userPts.toLocaleString();
  document.getElementById('shop-pts').textContent = userPts.toLocaleString();
  var name = currentItem.name;
  closeModal();
  showNotif(name + ' redeemed! Collect from the Sustainability Office.', 'success');
  renderShop(SHOP_ITEMS);
}


function saveProfile() {
  var msg = document.getElementById('save-msg');
  msg.classList.add('visible');
  showNotif('Profile updated successfully.', 'success');
  setTimeout(function() { msg.classList.remove('visible'); }, 3000);
}


var PALETTE = ['#1a0a3c','#1a0a3c','#1a0a3c','#7b2fff','#00f5d4','#ffd60a','#ff3864','#39ff14','#ff6b35'];

function randomizePixels() {
  var cells = document.querySelectorAll('.pixel-cell');
  cells.forEach(function(c) {
    c.style.background = PALETTE[Math.floor(Math.random() * PALETTE.length)];
  });
}

function buildPixelGrid() {
  var grid = document.getElementById('pixel-grid');
  if (!grid) return;
  var pattern = [
    0,0,2,2,2,2,0,0,0,0,2,2,2,2,0,0,
    0,2,2,3,3,2,2,0,0,2,2,3,3,2,2,0,
    2,2,3,3,3,3,2,2,2,2,3,3,3,3,2,2,
    2,3,3,1,3,3,3,2,2,3,3,3,1,3,3,2,
    2,3,3,3,3,3,3,2,2,3,3,3,3,3,3,2,
    2,2,3,4,3,4,2,2,2,2,3,4,3,4,2,2,
    0,2,2,3,3,2,2,0,0,2,2,3,3,2,2,0,
    0,0,2,2,2,2,0,0,0,0,2,2,2,2,0,0,
    0,0,0,5,5,5,5,5,5,5,5,5,0,0,0,0,
    0,0,5,5,5,5,5,5,5,5,5,5,5,0,0,0,
    0,5,5,0,5,5,5,5,5,5,5,0,5,5,0,0,
    0,5,5,5,5,5,5,5,5,5,5,5,5,5,0,0,
    0,0,5,5,0,5,5,0,0,5,5,0,5,5,0,0,
    0,0,0,5,5,5,0,0,0,0,5,5,5,0,0,0,
    0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,
    0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0
  ];
  var colors = ['#1a0a3c','#7b2fff','#ffd60a','#ff3864','#ff6b35','#00f5d4'];
  grid.innerHTML = '';
  pattern.forEach(function(v) {
    var cell = document.createElement('div');
    cell.className = 'pixel-cell';
    cell.style.background = colors[v] || '#1a0a3c';
    grid.appendChild(cell);
  });
}


function showNotif(msg, type) {
  type = type || '';
  var stack = document.getElementById('notif-stack');
  var n = document.createElement('div');
  n.className = 'notif ' + type;
  n.textContent = msg;
  stack.appendChild(n);
  setTimeout(function() {
    n.style.opacity = '0';
    n.style.transform = 'translateX(20px)';
    n.style.transition = 'all 0.3s';
    setTimeout(function() { n.remove(); }, 300);
  }, 3000);
}


document.addEventListener('DOMContentLoaded', function() {
  buildPixelGrid();
  renderShop(SHOP_ITEMS);
});
