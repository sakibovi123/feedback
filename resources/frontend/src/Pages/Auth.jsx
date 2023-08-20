import React, { useState, useEffect } from 'react'
import authImage from "../Assets/Images/3198965.jpg"
import Header from '../Components/Header'
import AuthUser from '../Context/Auth'
import { useNavigate } from 'react-router-dom'
// import { useNavigate } from "react-router-dom";


export default function Auth() {
  const navigate = useNavigate()
  const [ active, setActive ] = useState(false)
  const [ name, setName ] = useState()
  const [ email, setEmail ] = useState()
  const [ password, setPassword ] = useState()

  const { http, setToken } = AuthUser()

  const handleLogin = () => {
    try{
      http.post("/login", {
        email: email,
        password: password
      })
      .then((response) => {
        // console.log(response.data.access_token)
        setToken(response.data.user, response.data.access_token)
      })
    }
    catch(e) {
      return e
    }
    
  }

  const handleRegistration = () => {
    http.post("/register", {
      email: email,
      name: name,
      password: password
    })
    .then((response) => {
      navigate("/auth")
      setActive(true)
    })
  }
  
  // useEffect(() => {
     
  // }, [])



  return (
    <div className="min-h-screen w-full bg-slate-100">
      <Header />
      <div className="flex flex-col items-center justify-center h-full my-7">
        <div className="container mx-auto auth-form bg-white w-[60%] h-[720px] shadow-md rounded md:flex">
            <div className="w-full flex flex-col md:flex-row items-center">
                <img src={authImage} className="w-[50%] h-full border-r-[1px] h-ful" alt="" />
                <div className="flex flex-col mx-5 w-full h-full">
                    <div className="flex items-center justify-around p-5">
                      <button type="button" onClick={()=>setActive(true)}
                       className={`border-b-[1px] w-full p-2 border-r-[1px] ${active ? "border-blue-700" : ""}`}>Sign up</button>
                      <button type="button" onClick={()=>setActive(false)}
                       className={`border-b-[1px] w-full p-2 border-r-[1px] ${active ? "" : "border-blue-700"}`}>Sign in</button>
                    </div>
                    {
                      active ?
                      <div className="flex flex-col w-full">
                        <label htmlFor="Name" className="text-lg font-semibold">Name</label>    
                        <input type="text" onChange={(e) => setName(e.target.value)} required className="border outline-blue-300 w-full p-2" placeholder="Enter username" />
                        <label htmlFor="Email" required className="text-lg font-semibold">Email</label>    
                        <input type="email" onChange={(e) => setEmail(e.target.value)} required className="border outline-blue-300 w-full p-2" placeholder="Enter email" />
                        <label htmlFor="Name" className="text-lg font-semibold">Password</label>    
                        <input type="password" onChange={(e) => setPassword(e.target.value)} required className="border outline-blue-300 w-full p-2" placeholder="Enter username" />
                        
                        <button type="button" onClick={handleRegistration} className="bg-slate-900 text-white font-bold rounded my-4 p-2">
                            Sign Up
                        </button>

                      </div>
                  :
                  <div className="flex flex-col w-full">
                    <label htmlFor="Email" required className="text-lg font-semibold">Email</label>    
                    <input type="email" onChange={(e) => setEmail(e.target.value)} required className="border outline-blue-300 w-full p-2" placeholder="Enter email" />
                    <label htmlFor="Name" className="text-lg font-semibold">Password</label>    
                    <input  type="password" onChange={(e) => setPassword(e.target.value)} required className="border outline-blue-300 w-full p-2" placeholder="Enter username" />
                    
                    <button type="button" onClick={handleLogin} className="bg-slate-900 text-white font-bold rounded my-4 p-2">
                    
                        SIGN IN
                    </button>

                  </div>    
                    }
                    

                    
                </div>
            </div>
        </div>
      </div>
    </div>
  )
}
