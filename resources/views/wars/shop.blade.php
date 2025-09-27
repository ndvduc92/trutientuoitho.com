@extends('layouts.master')
@section('content')
<style>
    /* Main content */
    .main-content {
        display: flex;
        flex-direction: column;
    }

    .section-title {
        display: flex;
        align-items: center;
        margin-bottom: 25px;
    }

    .section-title h2 {
        margin: 0;
        font-size: 2rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
    }

    .decorative-line {
        flex: 1;
        height: 2px;
        background: #1baac2;
        margin-left: 20px;
        opacity: 0.5;
    }

    /* Alert messages */
    .alert-message {
        background-color: rgba(0, 0, 0, 0.3);
        border: 1px solid var(--border-color);
        border-radius: 5px;
        padding: 10px 15px;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        display: none;
    }

    .alert-message i {
        font-size: 1.2rem;
        margin-right: 10px;
    }

    .alert-message.success {
        border-color: #2ecc71;
        color: #2ecc71;
    }

    .alert-message.error {
        border-color: #e74c3c;
        color: #e74c3c;
    }

    /* Category tabs (like in the stash page) */
    .shop-categories {
        background: rgba(0, 0, 0, 0.2);
        border-radius: 10px;
        overflow: hidden;
        border: 1px solid var(--border-color);
        margin-bottom: 20px;
    }

    .category-tabs {
        display: flex;
        border-bottom: 1px solid var(--border-color);
        overflow-x: auto;
        white-space: nowrap;
        scrollbar-width: thin;
        scrollbar-color: var(--accent-color) rgba(0, 0, 0, 0.3);
    }

    .category-tabs::-webkit-scrollbar {
        height: 4px;
    }

    .category-tabs::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.3);
    }

    .category-tabs::-webkit-scrollbar-thumb {
        background-color: var(--accent-color);
        border-radius: 20px;
    }

    .category-tab {
        padding: 12px 20px;
        color: var(--text-color);

        text-decoration: none;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.9rem;
        border-right: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .category-tab:hover {
        background: rgba(212, 175, 55, 0.1);
        color: var(--accent-color);
    }

    .category-tab.active {
        background: rgba(212, 175, 55, 0.15);
        color: var(--accent-color);
        box-shadow: inset 0 -2px 0 var(--accent-color);
    }

    /* View toggle (Grid/List) */
    .view-controls {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 15px;
    }

    .view-toggle {
        display: flex;
        background: rgba(0, 0, 0, 0.3);
        border: 1px solid var(--border-color);
        border-radius: 5px;
        overflow: hidden;
    }

    .view-toggle a {
        display: flex;
        align-items: center;
        padding: 8px 15px;
        color: var(--text-color);
        text-decoration: none;
        transition: all 0.3s;
    }

    .view-toggle a i {
        margin-right: 5px;
    }

    .view-toggle a:hover {
        background: rgba(212, 175, 55, 0.1);
        color: var(--accent-color);
    }

    .view-toggle a.active {
        background: rgba(212, 175, 55, 0.15);
        color: var(--accent-color);
    }

    /* Shop container - grid and item preview */
    .shop-container {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
    }

    /* Shop grid */
    .shop-grid-container {
        background: var(--card-gradient);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 5px 15px var(--shadow-color);
    }

    .shop-items-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
        gap: 15px;
    }

    /* Shop item styling (to match stash.php) */
    .shop-item {
        background-color: rgba(0, 0, 0, 0.3);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        height: 130px;
    }

    .shop-item:hover {
        border-color: var(--accent-color);
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3), 0 0 5px var(--accent-glow);
    }

    .shop-item.active {
        border-color: var(--accent-color);
        box-shadow: 0 0 10px var(--accent-glow);
        background-color: rgba(212, 175, 55, 0.1);
    }

    .item-icon {
        width: 50px;
        height: 50px;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 10px;
    }

    .item-icon img {
        max-width: 100%;
        max-height: 100%;
    }

    .item-info {
        width: 100%;
        text-align: center;
    }

    .item-name {
        font-size: 0.85rem;
        color: var(--text-color);
        margin-bottom: 5px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 1.3;
    }

    .item-label {
        display: inline-block;
        background-color: rgba(212, 175, 55, 0.1);
        color: var(--accent-color);
        font-size: 0.7rem;
        padding: 2px 8px;
        border-radius: 3px;
        margin-bottom: 5px;
    }

    .item-label i {
        margin-left: 2px;
        font-size: 0.65rem;
    }

    .quantity-label {
        font-size: 0.75rem;
        color: #2ecc71;
        font-weight: 600;
    }

    /* Item preview panel */
    .item-preview {
        background: var(--card-gradient);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 5px 15px var(--shadow-color);
        position: sticky;
        top: 20px;
    }

    .preview-empty {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        color: var(--text-muted);
        text-align: center;
    }

    .preview-empty i {
        font-size: 3rem;
        margin-bottom: 15px;
        color: var(--border-color);
    }

    .preview-empty p {
        font-size: 1rem;
        margin: 0;

    }

    .item-details {
        display: none;
    }

    .item-details h3 {
        font-size: 1.3rem;
        margin-top: 0;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid var(--border-color);
    }

    .item-image {
        display: flex;
        justify-content: center;
        margin-bottom: 20px;
    }

    .item-image img {
        max-width: 80px;
        max-height: 80px;
        filter: drop-shadow(0 0 5px var(--accent-glow));
    }

    .item-description {
        background-color: rgba(0, 0, 0, 0.2);
        border: 1px solid var(--border-color);
        border-radius: 5px;
        padding: 15px;
        margin-bottom: 20px;
        font-size: 0.9rem;
        color: var(--text-color);
        line-height: 1.6;
    }

    .price-display {
        background-color: rgba(0, 0, 0, 0.2);
        border: 1px solid var(--border-color);
        border-radius: 5px;
        padding: 10px 15px;
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .price-label {
        color: var(--text-muted);
        font-size: 0.9rem;
    }

    .price-value {
        display: flex;
        align-items: center;
        font-size: 1rem;
        color: var(--accent-color);
        font-weight: 600;
    }

    .price-value i {
        margin-left: 5px;
    }

    /* Quantity selector */
    .quantity-selector {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    .quantity-label {
        margin-right: 10px;
        color: var(--text-muted);
    }

    .quantity-controls {
        display: flex;
        align-items: center;
        border: 1px solid var(--border-color);
        border-radius: 5px;
        overflow: hidden;
    }

    .quantity-btn {
        width: 30px;
        height: 30px;
        background-color: rgba(0, 0, 0, 0.3);
        border: none;
        color: var(--text-color);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .quantity-btn:hover {
        background-color: rgba(212, 175, 55, 0.2);
        color: var(--accent-color);
    }

    .quantity-input {
        width: 60px;
        text-align: center;
        border: none;
        border-left: 1px solid var(--border-color);
        border-right: 1px solid var(--border-color);
        background-color: rgba(0, 0, 0, 0.2);
        color: var(--text-color);
        height: 30px;
        font-size: 0.9rem;
    }

    .quantity-input:focus {
        outline: none;
        background-color: rgba(0, 0, 0, 0.4);
    }

    /* Purchase button */
    .purchase-button {
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--button-gradient);
        color: var(--primary-bg);
        font-weight: bold;
        border: none;
        border-radius: 5px;
        padding: 12px 0;
        cursor: pointer;
        transition: all 0.3s ease;

        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 10px;
    }

    .purchase-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    .purchase-button i {
        margin-right: 8px;
    }

    /* No items message */
    .no-items-message {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        color: var(--text-muted);
        text-align: center;
    }

    .no-items-message i {
        font-size: 2.5rem;
        margin-bottom: 15px;
        color: var(--border-color);
    }

    /* Footer */
    .footer {
        margin-top: auto;
        background: var(--header-gradient);
        padding: 20px 0;
        color: var(--text-muted);
        text-align: center;
        border-top: 1px solid var(--border-color);
    }

    /* Responsive layout */
    @media (max-width: 1200px) {
        .shop-dashboard {
            width: 95%;
        }
    }

    @media (max-width: 992px) {
        .shop-dashboard {
            grid-template-columns: 1fr;
        }

        .sidebar {
            display: none;
        }

        .shop-header {
            flex-direction: column;
            gap: 15px;
            align-items: flex-start;
        }

        .shop-stats {
            width: 100%;
        }

        .shop-container {
            grid-template-columns: 1fr;
        }

        .item-preview {
            position: static;
            margin-top: 20px;
        }
    }

    @media (max-width: 768px) {
        .shop-items-grid {
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
        }

        .shop-header {
            flex-direction: column;
        }

        .shop-stats {
            margin-top: 10px;
        }
    }


    /* Animations */
    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(46, 204, 113, 0.7);
        }

        70% {
            box-shadow: 0 0 0 6px rgba(46, 204, 113, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(46, 204, 113, 0);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }
</style>

<div class="shop-container">
    <!-- Shop items grid -->
    <div class="shop-grid-container">
        <div class="shop-items-grid" id="shop-items-view">
            @foreach ($shops as $item)
            <div class="shop-item" id="item-{{$item->id}}" data-id="{{$item->id}}" data-name="{{$item->item->name}}"
                data-desc="{{$item->description}}" data-gold="0" data-point="{{$item->price}}"
                data-item-id="{{$item->id}}" data-octet="0" data-max="{{$item->stack}}" data-item-count="1">
                <div class="item-icon"><img src="{{$item->item->image}}"></div>
                <div class="item-info">
                    <div class="item-name">{{ $item->item->name }}</div>
                    <div class="item-label">{!! number_format($item->price) !!} <i class="fas fa-coins"></i></div>
                </div>
            </div>
            @endforeach

        </div>
    </div>

    <!-- Item preview panel -->
    <div class="item-preview">
        <div id="preview-empty" class="preview-empty">
            <i class="fas fa-shopping-bag"></i>
            <p>Chọn vật phẩm để xem</p>
        </div>

        <div id="item-details" class="item-details">
            <h3 id="item-name-display">Item Name</h3>

            <div class="item-image">
                <img id="item-image-display" src="/static/0.gif" alt="Item">
            </div>

            <div id="item-description-display" class="item-description">
                Item description will appear here.
            </div>

            <div class="price-display">
                <span class="price-label">Giá tiền:</span>
                <span class="price-value">
                    <span id="item-price-display">0</span>
                    <i class="fas fa-gem"></i> xu war
                </span>
            </div>

            <!-- Quantity Selector -->
            <form action="" method="POST">
                @csrf
                <div class="quantity-selector">
                    <label class="quantity-label" for="quantity">Số lượng:</label>
                    <input type="hidden" id="shop_id" name="shop_id" value="{{$item->id}}">
                    <div class="quantity-controls">
                        <input type="number" id="quantity-input" class="quantity-input" value="1" min="1"
                            name="quantity" max="1" required>
                    </div>
                </div>

                <!-- Purchase Button -->
                <button class="btn-primary btn" type="submit" style="width: 100%">
                    <i class="fas fa-shopping-cart"></i> Mua ngay
                </button>
            </form>

        </div>
    </div>
</div>
<script>
    // Global variables
    var currentItem = null;  // Currently selected item
    var RMoney = 0;          // Character gold
    var UPoint = 0;  // Account points
    var currentQuantity = 1; // Selected quantity
    var maxQuantity = 1;     // Maximum allowed quantity
    var currentView = 'grid'; // Current view mode (grid/list)

    var charId = "{{ auth()->user()->main_id }}"; // Character ID from Blade template
    console.log('Character ID:', charId);
  
    // Initialize when document is ready
    document.addEventListener('DOMContentLoaded', function() {
      
        // Set up event listeners for shop items
        setupItemListeners();
        
        // Set up quantity input listener
        var quantityInput = document.getElementById('quantity-input');
        if (quantityInput) {
            quantityInput.addEventListener('input', handleQuantityInput);
            quantityInput.addEventListener('change', handleQuantityChange);
            quantityInput.addEventListener('keypress', handleQuantityKeypress);
        }
    });
    
    // Set up listeners for shop items
    function setupItemListeners() {
        var shopItems = document.getElementsByClassName('shop-item');
        for (var i = 0; i < shopItems.length; i++) {
            shopItems[i].addEventListener('click', function() {
                selectItem(this);
            });
        }
    }
    
    // Handle quantity input typing
    function handleQuantityInput(event) {
        var value = event.target.value;
        
        // Remove any non-numeric characters
        value = value.replace(/[^0-9]/g, '');
        
        // Update the input value
        event.target.value = value;
        
        // Update current quantity if valid
        if (value !== '') {
            var numValue = parseInt(value);
            if (!isNaN(numValue) && numValue >= 1) {
                currentQuantity = numValue;
            }
        }
    }
    
    // Handle quantity change (when input loses focus)
    function handleQuantityChange(event) {
        var value = parseInt(event.target.value);
        
        // Validate the value
        if (isNaN(value) || value < 1) {
            value = 1;
        } else if (value > maxQuantity) {
            value = maxQuantity;
            showError('Maximum quantity for this item is ' + maxQuantity);
        }
        
        // Update the input and current quantity
        event.target.value = value;
        currentQuantity = value;
    }
    
    // Handle Enter key press in quantity input
    function handleQuantityKeypress(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            processPurchase();
        }
    }
    
    // Change view mode (grid/list)
    function changeView(view, event) {
        if (event) event.preventDefault();
        
        // Skip if already in this view
        if (currentView === view) return;
        
        // Update active state in toggle buttons
        var viewButtons = document.querySelectorAll('.view-toggle a');
        for (var i = 0; i < viewButtons.length; i++) {
            viewButtons[i].classList.remove('active');
        }
        
        // Add active class to clicked button
        event.currentTarget.classList.add('active');
        
        // Change the view
        var itemsContainer = document.getElementById('shop-items-view');
        
        if (view === 'grid') {
            itemsContainer.className = 'shop-items-grid';
            
            // Change item classes for grid view
            var items = itemsContainer.querySelectorAll('.shop-item');
            for (var i = 0; i < items.length; i++) {
                items[i].classList.remove('list-view');
                items[i].classList.add('grid-view');
            }
        } else {
            itemsContainer.className = 'shop-items-list';
            
            // Change item classes for list view
            var items = itemsContainer.querySelectorAll('.shop-item');
            for (var i = 0; i < items.length; i++) {
                items[i].classList.remove('grid-view');
                items[i].classList.add('list-view');
            }
        }
        
        currentView = view;
    }
    
    // Select an item and show its details
    function selectItem(itemElement) {
        // Reset all items to non-active state
        var shopItems = document.getElementsByClassName('shop-item');
        for (var i = 0; i < shopItems.length; i++) {
            shopItems[i].classList.remove('active');
        }
        
        // Mark selected item as active
        itemElement.classList.add('active');
        
        // Get item data with proper validation
        var id = parseInt(itemElement.getAttribute('data-id')) || 0;
        if (id <= 0) {
            console.error("Invalid item ID:", id);
            return;
        }
        
        var name = itemElement.getAttribute('data-name') || "Unknown Item";
        var desc = itemElement.getAttribute('data-desc') || "No description available.";
        var pointPrice = parseInt(itemElement.getAttribute('data-point')) || 0;
        var itemId = parseInt(itemElement.getAttribute('data-item-id')) || 0;
        var octet = itemElement.getAttribute('data-octet') || '';
        maxQuantity = parseInt(itemElement.getAttribute('data-max')) || 1;
        var itemCount = parseInt(itemElement.getAttribute('data-item-count')) || 1;
        
        // Get item image
        var imgElement = itemElement.querySelector('img');
        var imgSrc = imgElement ? imgElement.src : '/static/0.gif';
        
        // Store current item data
        currentItem = {
            id: id,
            name: name,
            desc: desc,
            pointPrice: pointPrice,
            itemId: itemId,
            octet: octet,
            maxQuantity: maxQuantity,
            imgSrc: imgSrc,
            itemCount: itemCount
        };
        
        // Reset quantity
        currentQuantity = 1;
        var quantityInput = document.getElementById('quantity-input');
        if (quantityInput) {
            quantityInput.value = 1;
            quantityInput.max = maxQuantity;
        }
        
        // Update preview panel
        updateItemPreview();
    }
    
    // Update the item preview panel
    function updateItemPreview() {
        if (!currentItem) return;
        console.log(currentItem)
        // Hide empty state
        document.getElementById('preview-empty').style.display = 'none';
        
        // Show item details
        var detailsElement = document.getElementById('item-details');
        detailsElement.style.display = 'block';
        
        // Update item name
        document.getElementById('item-name-display').textContent = currentItem.name;
        
        
         // Update item name
        document.getElementById('shop_id').value = currentItem.id;
        
        // Update item image
        document.getElementById('item-image-display').src = currentItem.imgSrc;
        
        // Format description
        var descElement = document.getElementById('item-description-display');
        var descHtml = '';
        if (currentItem.desc && currentItem.desc.trim() !== '') {
            if (currentItem.desc.indexOf('*') !== -1) {
                descHtml = currentItem.desc.split('*').join('<br>');
            } else {
                descHtml = currentItem.desc;
            }
        } else {
            descHtml = 'No description available.';
        }
        descElement.innerHTML = descHtml;
        
        // Update price
        document.getElementById('item-price-display').textContent = currentItem.pointPrice;
        
        // Show/hide quantity selector based on max quantity
        var quantityContainer = document.getElementById('quantity-container');
        if (quantityContainer) {
            if (maxQuantity > 1) {
                quantityContainer.style.display = 'flex';
            } else {
                quantityContainer.style.display = 'none';
            }
        }
        
        // Add item count display if needed
        if (currentItem.itemCount > 1) {
            var itemPriceElement = document.getElementById('item-price-display');
            if (itemPriceElement) {
                itemPriceElement.parentNode.innerHTML = 
                    '<span id="item-price-display">' + currentItem.pointPrice + '</span> ' +
                    '<i class="fas fa-gem"></i>' +
                    '<span style="margin-left:8px;font-size:0.8rem;color:#2ecc71;">×' + currentItem.itemCount + ' per purchase</span>';
            }
        }
    }
    
    // Increment quantity
    function incrementQuantity() {
        if (currentQuantity < maxQuantity) {
            currentQuantity++;
            document.getElementById('quantity-input').value = currentQuantity;
        }
    }
    
    // Decrement quantity
    function decrementQuantity() {
        if (currentQuantity > 1) {
            currentQuantity--;
            document.getElementById('quantity-input').value = currentQuantity;
        }
    }

    
    // Format number with commas
    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
</script>
@endsection