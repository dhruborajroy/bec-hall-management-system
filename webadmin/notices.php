<?php include("header.php");?>
<div class="dashboard-content-one">
    <!-- Breadcubs Area Start Here -->
    <div class="breadcrumbs-area">
        <h3>Noticeboard</h3>
        <ul>
            <li>
                <a href="index.php">Home</a>
            </li>
            <li>Notice</li>
        </ul>
    </div>
    <!-- Breadcubs Area End Here -->
    <div class="row">
        <!-- All Notice Area Start Here -->
        <div class="col-8-xxxl col-12">
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>Notice Board</h3>
                        </div>
                        <div class="dropdown">
                            <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                                aria-expanded="false">...</a>

                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                                <a class="dropdown-item" href="#"><i
                                        class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                <a class="dropdown-item" href="#"><i
                                        class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                            </div>
                        </div>
                    </div>
                    <!-- <form class="mg-b-20">
                        <div class="row gutters-8">
                            <div class="col-lg-5 col-12 form-group">
                                <input type="text" placeholder="Search by Date ..." class="form-control">
                            </div>
                            <div class="col-lg-5 col-12 form-group">
                                <input type="text" placeholder="Search by Title ..." class="form-control">
                            </div>
                            <div class="col-lg-2 col-12 form-group">
                                <button type="submit" class="fw-btn-fill btn-gradient-yellow">SEARCH</button>
                            </div>
                        </div>
                    </form> -->
                    <div class="notice-board-wrap">
                        <?php 
                        $sql="select * from notice where status='1' order by added_on desc";
                        $res=mysqli_query($con,$sql);
                        if(mysqli_num_rows($res)>0){
                        $i=1;
                        while($row=mysqli_fetch_assoc($res)){
                        ?>
                        <div class="notice-list">
                            <div class="post-date bg-skyblue">
                                <?php echo date('d-M-Y h:i A',$row['added_on']);
                                // echo time()?>
                            </div>
                            <div class="post-date bg-orange">
                                <a href="manage_notice?id=<?php echo $row['id']?>" style="color:black">Edit</a>
                            </div>
                            <div class="post-date bg-orange">
                                <a href="./pdfreports/notice.php?notice_id=<?php echo $row['id']?>" style="color:white">Generate Pdf</a>
                            </div>

                            <h6 class="notice-title"><a href="#"><?php echo $row['title']?></a></h6>
                            <div class="entry-meta"><?php echo $row['details']?></div>
                        </div>
                        <?php 
                           $i++;
                           } } else { ?>
                        <tr>
                            <td colspan="5">No data found</td>
                        </tr>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- All Notice Area End Here -->
    </div> <?php include("footer.php")?>