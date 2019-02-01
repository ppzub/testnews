<template>
  <div id="app" v-on-clickaway="away" v-on:keyup.esc="away">

    <div class="span3 calendar_text text_siryj padd_t1" style="width: 148px;">
      {{moment().format('dddd')}} <span class="chas_calendar">
      {{moment().format('HH:mm')}}</span><br>{{moment().format('DD MMMM YYYY')}}
    </div>
    <!-- календар -->
    <div class="span1 dropdown prof-login open">
      <a v-on:click.prevent="clicked = !clicked" class="dropdown-toggle"
         href="#"
         data-toggle="dropdown">
        <div class="calendar marg_null"></div>
      </a>

      <div style="clear:both;"></div>
      <div v-if="clicked" class="dropdown-menu block_calendar"
           style="padding: 5px; padding-bottom: 0px;width: 210px;height: 320px;left: auto;right: 0; z-index: 10001;">
        <div class="row-fluid">
          <div v-on:click="prevYear" data-slide="prevYear"
               class="update-calendar pull-left span1 offset3 text_al_l font18_calendar">
            <strong>
              &lt; </strong></div>
          <div class="pull-left span4 text_al_c pad_year">{{year}}</div>
          <div v-on:click="nextYear" data-slide="nextYear"
               class="update-calendar pull-left span1 text_al_r font18_calendar">
            <strong> &gt;</strong></div>
        </div>
        <div class="row-fluid">
          <div class="pull-left span2">
            <a v-on:click.prevent="prevMonth"
               class="carousel-control left left_cal4 update-calendar"
               href="#"
               data-slide="prevMonth">
              <div class="left_cal4_bl"></div>
            </a>
          </div>
          <div class="pull-left month_c span8 text_al_c">
            {{moment().month(month).format('MMMM')}}
          </div>
          <div class="pull-left span2">
            <a v-on:click.prevent="nextMonth"
               class="carousel-control right right_cal4 update-calendar"
               href="#"
               data-slide="nextMonth">
              <div class="right_cal4_bl"></div>
            </a>
          </div>
        </div>
        <div class="row-fluid margbut">
          <div class="day_calendar">ПН</div>
          <div class="day_calendar">ВТ</div>
          <div class="day_calendar">СР</div>
          <div class="day_calendar">ЧТ</div>
          <div class="day_calendar">ПТ</div>
          <div class="day_calendar">СБ</div>
          <div class="day_calendar">НД</div>
        </div>
        <div class="fon_line1 row-fluid"></div>
        <div class="row-fluid">
          <div v-for="n in dates[0].day() - 1"
               class="day_number_calendar next_month"></div>
          <div v-for="date, index in dates">
            <div v-if="date <= moment()" class="day_number_calendar">

              <a v-bind:href="date.format('YYYY-MM-DD')">{{date.date()}}</a>

            </div>
            <div v-else class="day_number_calendar next_month">{{date.date()}}</div>
          </div>
          <div class="day_number_calendar next_month"></div>
        </div>
      </div>
    </div>
    <!-- календар кінець-->
  </div>
</template>

<script>
  import {mixin as clickaway} from 'vue-clickaway';

  let moment = require('moment-timezone');
  moment.tz.setDefault('Europe/Kyiv');
  moment.locale('uk');
  export default {
    mixins: [clickaway],
    name: 'app',
    data() {
      return {
        moment: moment,
        clicked: false,
        year: null,
        month: null,
        startDate: '',
        endDate: '',
        dates: []
      }
    },
    created() {
      this.year = moment().year();
      this.month = moment().month();
    },
    mounted() {

      this.changeDate();
    },
    filters: {
      moment: function (date) {
        return moment(date).format('MMMM Do YYYY, h:mm:ss a');
      }
    },
    methods: {
      away: function () {
        this.clicked = false;
      },
      date: function (date) {
        return moment(date).format('MMMM Do YYYY, h:mm:ss a');
      },
      nextYear: function () {
        this.year++;
        this.changeDate();
      },
      prevYear: function () {
        this.year--;
        this.changeDate();
      },
      nextMonth: function () {
        this.month++;
        if (this.month === 12) {
          this.month -= 12;
          this.year++;
        }
        this.changeDate();
      },
      prevMonth: function () {
        this.month--;
        if (this.month === -1) {
          this.month += 12;
          this.year--;
        }
        this.changeDate();
      },
      changeDate: function () {
        this.dates = [];
        this.startDate = moment().year(this.year).month(this.month).startOf('month');
        this.endDate = moment().year(this.year).month(this.month).endOf('month');
        let day = this.startDate;

        while (day <= this.endDate) {
          this.dates.push(day);
          day = day.clone().add(1, 'days');
        }
      }
    }
  }
</script>

