import { Datepicker } from 'flowbite-react'
import Calendar, { YearView } from 'react-calendar';
import React from 'react'
import 'react-calendar/dist/Calendar.css';

function Professional() {
  return (
    <Calendar className={`border-none w-full [&>div:nth-child(1)]:justify-end [&>div:nth-child(1)]:relative [&>div:nth-child(1)>button:nth-child(1)]:hidden [&>div:nth-child(1)>button:nth-child(5)]:hidden [&>div:nth-child(1)>button:nth-child(3)]:flex-grow-0 [&>div:nth-child(1)>button:nth-child(3)]:absolute [&>div:nth-child(1)>button:nth-child(3)]:left-0 [&>div:nth-child(1)>button:nth-child(3)]:top-4 [&>div:nth-child(1)>button:nth-child(3)]:pointer-events-none [&>div:nth-child(1)>button:nth-child(3)>span]:font-serif [&>div:nth-child(1)>button:nth-child(3)>span]:font-semibold [&>div:nth-child(2)>div>div>div>div:nth-child(2)>button]:pointer-events-none [&>div:nth-child(2)>div>div>div>div:nth-child(1)>div>abbr]:no-underline` } minDate={new Date()} />
  )
}

export default Professional