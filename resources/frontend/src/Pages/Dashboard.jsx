import React from 'react'
import Header from '../Components/Header'
import { Link } from 'react-router-dom'


export default function Dashboard() {
  return (
    <div className="bg-slate-100">
      <Header />

      <div className="container mx-auto my-9 h-screen w-[50%]">
        <div className="flex items-start justify-between bg-white shadow-md rounded p-5 h-full">
          <div className="w-[30%] border-r-[2px] h-full flex flex-col">
            <Link>FEEDS</Link>
            <Link>CREATE FORMS</Link>
            <Link>ALL FORMS</Link>
          </div>
          <div className="w-[70%] mx-5">
            <Link>FORMS</Link>
          </div>
        </div>
      </div>

    </div>
  )
}
