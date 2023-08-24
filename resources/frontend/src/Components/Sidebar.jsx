import React from 'react'
import { Link } from 'react-router-dom'


export default function Sidebar() {
  return (
    <div>
       <div className="w-[70%] border-r-[2px] h-full flex flex-col">
            <Link className="text-md border-b-[1px] font-semibold">FEEDS</Link>
            <Link className="text-md border-b-[1px] font-semibold">CREATE FORMS</Link>
            <Link className="text-md border-b-[1px] font-semibold">ALL FORMS</Link>
          </div>
    </div>
  )
}
