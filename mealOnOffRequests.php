<?php include("header.php")?>
<div class="dashboard-content-one">
    <!-- Breadcubs Area Start Here -->
    <div class="breadcrumbs-area">
        <h3>Students</h3>
        <ul>
            <li>
                <a href="index.php">Home</a>
            </li>
            <li>Meal On Off Requests</li>
        </ul>
    </div>
    <!-- Breadcubs Area End Here -->
    <!-- Student Table Area Start Here -->
    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Meal On Off Requests</h3>
                </div>
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                        aria-expanded="false">...</a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                        <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                        <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                    </div>
                </div>
            </div>
            <form class="mg-b-20">
                <div class="row gutters-8">
                    <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
                        <input type="text" onkeyup="myFunction()" placeholder="Search by Roll ..." class="form-control"
                            id="myInput">
                    </div>
                    <!-- <div class="col-4-xxxl col-xl-4 col-lg-3 col-12 form-group">
                        <input type="text" placeholder="Search by Name ..." class="form-control">
                    </div>
                    <div class="col-4-xxxl col-xl-3 col-lg-3 col-12 form-group">
                        <input type="text" placeholder="Search by Class ..." class="form-control">
                    </div> -->
                    <div class="col-1-xxxl col-xl-2 col-lg-3 col-12 form-group">
                        <button type="submit" class="fw-btn-fill btn-gradient-yellow">SEARCH</button>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table display data-table text-nowrap">
                    <thead>
                        <tr>
                            <th>Roll</th>
                            <th>Name</th>
                            <th>Batch</th>
                            <th>Date</th>
                            <th>Dept.</th>
                            <th>
                                <div >
                                    <!-- <input type="checkbox" class="form-check-input checkAll"> -->
                                    <label class="form-check-label">status</label>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="myTable">
                        <tr>
                            <td>200130</td>
                            <td>Dhrubo Raj Roy</td>
                            <td>04 batch</td>
                            <td>16 May </td>
                            <td>CE</td>
                            <td>
                                <div class="ui-btn-wrap">
                                    <ul>
                                        <li><button type="button"
                                                class="btn-fill-lmd  text-light shadow-dark-pastel-green bg-dark-pastel-green">Approve</button>
                                        </li>
                                        <li><button type="button"
                                                class="btn-fill-xl  text-light shadow-orange-red bg-orange-red">Decline</button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Student Table Area End Here -->
    <?php include("footer.php")?>

    <script>
    function myFunction() {
        var input, filter, ul, li, a, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        ul = document.getElementById("myUL");
        li = ul.getElementsByTagName("li");
        for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                li[i].style.display = "";
            } else {
                li[i].style.display = "none";
            }
        }
    }
    </script>