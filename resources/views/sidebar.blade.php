<div class="list-group list-group-tree well">

  <a href="javascript:void(0);" class="list-group-item" data-toggle="collapse">
    <i class="fa fa-chevron"></i>
    Product Catalog
  </a>
  <div class="list-group collapse show">
    <a href="javascript:void(0);" class="list-group-item" data-toggle="collapse" onclick="redirectToCompanyPage()">
      <i class="fa fa-chevron"></i>
      Company
    </a>
    <div class="list-group collapse show list-child">
      <a href="javascript:void(0);" class="list-group-item" onclick="redirectTodistilleryPage()"><i class="fa fa-chevron"></i> Distilleries</a>
      <a href="javascript:void(0);" class="list-group-item" onclick="redirectToMerchantPage()"><i class="fa fa-chevron"></i> Merchants</a>
      <a href="javascript:void(0);" class="list-group-item" onclick="redirectToBrandPage()"><i class="fa fa-chevron"></i> Brands</a>
      <a href="javascript:void(0);" class="list-group-item" onclick="redirectToReleasePage()"><i class="fa fa-chevron"></i> Releases</a>
    </div>
  </div>
</div>

<style>
.list-group.list-group-tree {
  padding: 0;
}
.list-group.list-group-tree .list-group {
  margin-bottom: 0;
}
.list-group.list-group-tree > .list-group > .list-group-item {
  padding-left: 30px;
}
.list-group.list-group-tree > .list-group > .list-group > .list-group-item {
  padding-left: 48px;
}
.list-group.list-group-tree > .list-group > .list-group > .list-group-item > .list-group-item {
  padding-left: 60px;
}
.list-group.list-group-tree > .list-group > .list-group > .list-group-item > .list-group-item > .list-group-item {
  padding-left: 75px;
}
.list-group.list-group-tree > .list-group > .list-group > .list-group-item > .list-group-item > .list-group-item > .list-group-item {
  padding-left: 90px;
}
.list-group-item .fa {
  margin-right: 5px;
}
.fa-chevron:before {
  content: "\f054"; /* right */
}
.in > .fa-chevron:before {
  content: "\f078"; /* down */
}
.list-group-item.active {
  background-color: #0D6EFD;
  font-weight: bold;
  color: #ffffff;
}
</style>
<script>
$(function() {
    $(".list-group-tree").on('click', "[data-toggle=collapse]", function(){
      $(this).toggleClass('in');
      $(this).next(".list-group.collapse").collapse('toggle');
      return false;
    });

    function setActiveItem() {
        var url = window.location.pathname;
        console.log("Current URL:", url);

        $(".list-group-item").each(function() {
            var itemUrl = $(this).attr("onclick");

            if (itemUrl) {
                var match = itemUrl.match(/redirectTo(.*)Page/);
                if (match) {
                    var pageName = match[1].toLowerCase();
                    if (url.includes(pageName)) {
                        $(this).addClass("active");
                    }
                }
            }
        });
    }

    setActiveItem();
});

function redirectToCompanyPage() {
    window.location.href = "/list-company";
}

function redirectTodistilleryPage() {
    window.location.href = "/list-distillery";
}

function redirectToMerchantPage() {
    window.location.href = "/list-merchant";
}

function redirectToBrandPage() {
    window.location.href = "/list-brands";
}
function redirectToReleasePage() {
    window.location.href = "/list-releases";
}
</script>
