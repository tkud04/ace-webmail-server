<?php
$title = "Add FAQ";
$subtitle = "Add a question/answer pair to FAQs";
?>



<?php $__env->startSection('title',$title); ?>


<?php $__env->startSection('page-header'); ?>
<?php echo $__env->make('page-header',['title' => "Add FAQ",'subtitle' => $title], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div class="row">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Add FAQ</h5>
                                <div class="card-body">
                                    <form action="<?php echo e(url('add-faq')); ?>" id="faq-form" method="post">
										<?php echo csrf_field(); ?>

										
										<div class="row">
										<div class="col-md-12">
										<div class="form-group">
                                            <label for="faq-question">Question</label>
                                            <input id="faq-question" type="text" placeholder="Question" name="question" class="form-control">
                                        </div>
										</div>
										<div class="col-md-12">
										<div class="form-group">
                                            <label for="faq-answer">Answer</label>
                                             <textarea class="form-control" name="answer" id="faq-answer"></textarea>
                                        </div>
										</div>
										<div class="col-md-12">
										<div class="form-group">
                                            <h4>Tag</h4>
                                            <select class="form-control" name="tag" id="faq-tag" style="margin-bottom: 5px;">
							                  <option value="none">Select tag</option>
								           <?php
								              foreach($tags as $t){
									      	 
								           ?>
								              <option value="<?php echo e($t['tag']); ?>"><?php echo e($t['name']); ?></option>
								           <?php
								           }
								           ?>
							                </select>
                                        </div>
										</div>
										</div>
										
										
                                        <div class="row">
                                            <div class="col-sm-12 pl-0">
                                                <p class="text-right">
                                                    <button class="btn btn-space btn-secondary" id="faq-form-btn">Save</button>
                                                </p>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\bkupp\lokl\repo\etuk-admin\resources\views/add-faq.blade.php ENDPATH**/ ?>