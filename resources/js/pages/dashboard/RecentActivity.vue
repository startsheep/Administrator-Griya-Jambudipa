<template>
  <div class="card">
    <div class="card-header">
      <h4>Aktivitas Terbaru</h4>
    </div>
    <div class="card-body">
      <ul class="list-unstyled list-unstyled-border">
      <li class="media" v-for="activity in recentActivity" :key="activity">
          <img
            class="mr-3 rounded-circle"
            width="50"
            :src="activity.avatar"
            alt="avatar"
          />
          <div class="media-body">
            <div class="float-right text-primary">{{ activity.time }}</div>
            <div class="media-title">{{ activity.name }}</div>
            <span class="text-small text-muted"
              >{{ activity.activity     }}</span>
            >
          </div>
        </li>

      </ul>
      <div class="text-center pt-1 pb-1">
        <a href="#" class="btn btn-primary btn-lg btn-round"> View All </a>
      </div>
    </div>
  </div>
</template>
<script>
export default {
    data(){
        return {
            recentActivity: [
                {
                    id: 1,
                    avatar:'https://robohash.org/stefan-oneapi.lorem.space/image/face?w=150&h=150',
                    name: 'Farhan A Mujib',
                    activity: 'Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin.',
                    time: 'Now'
                },
                {
                    id: 2,
                    avatar:'https://robohash.org/stefan-oneapi.lorem.space/image/face?w=150&h=150',
                    name: 'Ujang Maman',
                    activity: 'Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin.',
                    time: '2 Hours Ago'
                },
                {
                    id: 3,
                    avatar:'https://robohash.org/stefan-oneapi.lorem.space/image/face?w=150&h=150',
                    name: 'Rizal Fakhri',
                    activity: 'Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin.',
                    time: '5 Hours Ago'
                },
                {
                    id: 4,
                    avatar:'https://robohash.org/stefan-oneapi.lorem.space/image/face?w=150&h=150',
                    name: 'Alfa Zulkarnain',
                    activity: 'Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin.',
                    time: '12 Hours Ago'
                },
                {
                    id: 5,
                    avatar:'https://robohash.org/stefan-oneapi.lorem.space/image/face?w=150&h=150',
                    name: 'Shayna Anne',
                    activity: 'Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin.',
                    time: '15 Hours Ago'
                },
                {
                    id: 6,
                    avatar:'https://robohash.org/stefan-oneapi.lorem.space/image/face?w=150&h=150',
                    name: 'Farhan A Mujib',
                    activity: 'Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin.',
                    time: 'Now'
                },
                {
                    id: 7,
                    avatar:'https://robohash.org/stefan-oneapi.lorem.space/image/face?w=150&h=150',
                    name: 'Ujang Maman',
                    activity: 'Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin.',
                    time: '2 Hours Ago'
                },
                {
                    id: 8,
                    avatar:'https://robohash.org/stefan-oneapi.lorem.space/image/face?w=150&h=150',
                    name: 'Rizal Fakhri',
                    activity: 'Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin.',
                    time: '5 Hours Ago'
                },
            ]
        }
    },
};
</script>
<style>
</style>
