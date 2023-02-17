let priceRange = "1000:10000";
let scrollCooldown = true;
let currentItems = 0;
let currentTotal = 0;
const populateProducts = (products) => {
    products.forEach(product => {
        let card = `
            <div class="col-lg-4 mt-3">
                <div class="card">
                <a href="product/${product.prod_sku}">
                    <img src="https://source.unsplash.com/user/sabrinnaringquist/500x500/?jewelry&rnd=${product.prod_sku}" class="img-fluid bw-effect" />
                </a>
                <div class="card-body pb-0">
                    <p class="card-text">
                    <span class="prod-name">${product.prod_name}</span><br>
                    <small class="prod-price text-muted">USD \$${product.price}</small><br><br>
                    <div>For ${product.prodmeta_section}</div>
                    </p>
                </div>
                </div>
            </div>
        `;
        $("#products").append(card);
    });
    if(products.length == 0 && currentItems == 0) {
        $("#products").html(`
            <div class="text-center mt-5"><h3>No Products Found For Your Request...</h3></div>
        `);
    }
};

const getProducts = () => {
    console.log(currentTotal,currentItems);
    if(currentTotal == 0 || currentTotal > currentItems) {
        Notiflix.Loading.pulse();
        $.get("api/products",{
            gender: $("#gender-filter").val(),
            price: $("#price-filter").val(),
            subcatg: $("#subcatg-filter").val(),
            priceRange,
            currentItems
        },(resp)=>{
            populateProducts(resp['result']);
            currentTotal = resp['total'];
            currentItems += resp['result'].length;
            console.log("Pulse Stop");
            Notiflix.Loading.remove();
        });
    }
};

const filterUpdateListener = () => {
    currentItems=0;
    $("#products").html("");
    getProducts();
};

$(document).ready(()=>{
    getProducts();
    $("#gender-filter").change(filterUpdateListener);
    $("#price-filter").change(filterUpdateListener);
    $("#subcatg-filter").change(filterUpdateListener);
    rangeSlider(document.querySelector('#price-range-slider'),{
        min: 1000,
        max: 10000,
        step: 500,
        value: [1000, 10000],
        onInput: function(valueSet) {
            priceRange = `${valueSet[0]}:${valueSet[1]}`;
            $("#price-range-slider-label").html(`Price Range (\$${valueSet[0]} - \$${valueSet[1]})`);
        },
    });
    $("#price-range-slider").on("mouseup", filterUpdateListener);


    
    window.onscroll = function (e) { 
        if(document.documentElement.scrollTop > document.body.clientHeight - window.innerHeight-100) {
            if(scrollCooldown) {
                scrollCooldown = !scrollCooldown;
                setTimeout(()=>{
                        scrollCooldown = !scrollCooldown;
                },10000);
                getProducts();
            }
        }
    }
});