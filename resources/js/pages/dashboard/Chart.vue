<template >
  <div class="card">
    <div class="card-header">
      <h4>Statistics</h4>
      <div class="card-header-action">
        <div class="btn-group">
          <a href="#" class="btn btn-primary">Week</a>
          <a href="#" class="btn">Month</a>
        </div>
      </div>
    </div>
    <div class="card-body">
      <canvas id="myChart" height="182"></canvas>
      <div class="statistic-details mt-sm-4">
        <div class="statistic-details-item">
          <span class="text-muted"
            ><span class="text-primary"><i class="fas fa-caret-up"></i></span>
            7%</span
          >
          <div class="detail-value">$243</div>
          <div class="detail-name">Today's Sales</div>
        </div>
        <div class="statistic-details-item">
          <span class="text-muted"
            ><span class="text-danger"><i class="fas fa-caret-down"></i></span>
            23%</span
          >
          <div class="detail-value">$2,902</div>
          <div class="detail-name">This Week's Sales</div>
        </div>
        <div class="statistic-details-item">
          <span class="text-muted"
            ><span class="text-primary"><i class="fas fa-caret-up"></i></span
            >9%</span
          >
          <div class="detail-value">$12,821</div>
          <div class="detail-name">This Month's Sales</div>
        </div>
        <div class="statistic-details-item">
          <span class="text-muted"
            ><span class="text-primary"><i class="fas fa-caret-up"></i></span>
            19%</span
          >
          <div class="detail-value">$92,142</div>
          <div class="detail-name">This Year's Sales</div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {};
</script>
<style >
</style>
