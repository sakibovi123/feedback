import React, { useState, useEffect } from 'react'
import Header from '../Components/Header'
import { Link } from 'react-router-dom'
import Sidebar from '../Components/Sidebar'
import AuthUser from '../Context/Auth'
import axios from 'axios'
import { useParams } from 'react-router-dom'
import { FiCopy } from "react-icons/fi"
import { BiShow } from "react-icons/bi"

export default function Dashboard() {
  const [ forms, setForms ] = useState([])
  const [ questions, setQuestions ] = useState([])
  const { http } = AuthUser()
  const formSlug = useParams()

  const url = "http://127.0.0.1:8000/api/forms"
  
  
  const getAllForms = async ()=> {
    try{
      const response = await http.get("/forms")
      setForms(response.data.data.data)
    }
    catch(e) {
      return e
    }  
  }


  useEffect(() => {
    getAllForms()
  }, [])


  return (
    <div className="bg-slate-100">
      <Header />

      <div className="container mx-auto my-9 h-screen w-[50%]">
        <div className="flex items-start justify-between bg-white shadow-md rounded p-5 h-full">
          <div className="w-full mx-5">
            {
              forms.map((f) => (
                
                <div className="flex items-center justify-between bg-white shadow-md border m-3 p-3 rounded">
                  <div>
                    <h2>Form Name: {f.name}</h2>
                  </div>
                  <div className="cursor-pointer flex items-center justify-between">
                    <FiCopy className="mx-2 text-2xl" />
                    <Link to={`/form-details/${f.slug}/`}>
                      <BiShow className="text-2xl"/>
                    </Link>
                    
                  </div>
                  
                </div>
                
              ))
            }
          </div>
        </div>
      </div>

    </div>
  )
}
