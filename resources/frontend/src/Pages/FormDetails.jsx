import React, { useState, useEffect } from 'react'
import Header from '../Components/Header'
import { useParams } from 'react-router-dom'
import AuthUser from '../Context/Auth'
import axios from 'axios'

export default function FormDetails() {
    const formSlug = useParams()
    // console.log(formSlug.slug)
    const { http } = AuthUser()
    const [ forms, setForms ] = useState("")
    const [ questions, setQuestions ] = useState([])
    const [ name, setName ] = useState()
    const [ email, setEmail ] = useState()
    const [ answers, setAnswers ] = useState([""])

    const handldAnswers = (index, value) => {
        const newAnswers = [...answers]
        newAnswers[index] = value
        setAnswers(newAnswers)
    }

    const handleResponse = async () => {
        const response  = await http.post(`/save-response/${formSlug.slug}/`, {
            name: name,
            email: email,
            answers: answers
        })
        .then(resp => {
            console.log(resp)
        })
        .catch(error => {
            return error
        })
    }

    const formDetails = async () => {
        try{
            const response = await http.get(`/form-details/${formSlug.slug}/`)
            .then(response => {
                setForms(response.data.data)
                setQuestions(response.data.data.questions)
            })
            
        } catch(error) {
            return error
        }
        
        
    }

    useEffect(()=>{
        formDetails()
    }, [])

    return (
        <div className="bg-slate-100">
            <Header />
            <div className="container mx-auto my-9 h-screen w-[50%]">
                <div className="flex items-start justify-between bg-white shadow-md rounded p-5 h-full">
                   <div className="w-full mx-5">
                   <div className="flex items-center justify-between bg-white shadow-md border m-3 p-3 rounded">
                        <div className="flex flex-col items-start justify-between w-full">
                            <h2 className="text-3xl font-bold">{forms.name}</h2>
                            <label htmlFor="Name">Enter name</label>
                            <input onChange={(e) => setName(e.target.value)} type="text" className="w-full border p-2 my-2 rounded outline-blue-500" placeholder="Enter Answer" />
                            <label htmlFor="Email">Enter email</label>
                            <input onChange={(e) => setEmail(e.target.value)} type="email" className="w-full border p-2 my-2 rounded outline-blue-500" placeholder="Enter Email" />
                            {
                                questions.map((q, index) => (
                                    <div key={q.id}>
                                        {q.question_title}
                                        <input onChange={(e) => handldAnswers(index, e.target.value)} type="text" className="w-full border p-2 my-2 rounded outline-blue-500" placeholder="Enter Answer" />
                                    </div>
                                ))
                            }
                            <button onClick={handleResponse}
                            className="bg-blue-600 p-2 w-[220px] rounded shadow-md text-white font-semibold my-3 hover:bg-blue-700">Send Response</button>
                        </div>
                        
                   </div>
                   </div>
                </div>
            </div>
        </div>
    )
}
