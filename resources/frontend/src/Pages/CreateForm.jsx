import React, { useState, useEffect } from 'react'
import Header from '../Components/Header'
import { Link } from 'react-router-dom'
import { AiOutlineMinusCircle } from "react-icons/ai"
import AuthUser from '../Context/Auth'
import axios from 'axios'

export default function CreateForm() {
  const [ questTitles, setQuestTitles ] = useState([''])
  const { http } = AuthUser()

  const { getToken } = AuthUser()
  // console.log(getToken())

  const handleQuestTitleChange = (index, value) => {
    const newQuestTitles = [...questTitles];
    newQuestTitles[index] = value;
    setQuestTitles(newQuestTitles);
  };

  const addDiv = () => {
    setQuestTitles([...questTitles, '']); // Add a new empty input
  };

  const removeDiv = (index) => {
    const newQuestTitles = [...questTitles];
    newQuestTitles.splice(index, 1);
    setQuestTitles(newQuestTitles);
  };


  const generateForm = () => {
    try{
      const response = http.post('/create-form', {
         question_titles: questTitles
      })
      .then((resp) => {
        console.log(resp)
      })
    }
    catch( error ) {
      console.error("Error: ", error)
    } 
  }

  return (
      <div className="bg-slate-100">
      <Header />
      <div className="container mx-auto my-9 h-screen w-[50%]">
        <div className="flex items-start justify-between bg-white shadow-md rounded p-5 h-full">
          <div className="w-full mx-5 flex flex-col">
            <div className="text-2xl font-bold">
              GENERATE FORM
            </div>
          {
            questTitles.map((title, index) => (
            <input
              required
              key={index}
              type="text"
              value={title}
              onChange={(e) => handleQuestTitleChange(index, e.target.value)}
              className="border outline-blue-400 mb-2 p-2 my-5" placeholder="Enter Question"
            />
          ))}
            {/* {divs} */}
            {/* <input type="text" onChange={(e)=>setQuestTitle(e.target.value)} className="border outline-blue-400" /> */}
            <div className="flex items-center justify-center">
              <button onClick={addDiv} className="bg-red-300 mr-5 p-2 w-[120px] rounded">Add More</button>
              <button onClick={removeDiv} className="bg-red-300 mr-5 p-2 w-[120px] rounded">Remove</button>
              <button onClick={generateForm} className="bg-blue-400 p-2 w-[120px] rounded">Save</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  )
}
