import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom';
import 'antd/dist/antd.css';
import axios from 'axios';
import { Form, Input, Divider, Table, Descriptions, Image, Button, Card, Space, message } from 'antd';

const columns = [
    { title: 'id', dataIndex: 'id', key: 'id' },
    { title: 'Name', dataIndex: 'name', key: 'name' },
    { title: 'Address', dataIndex: 'address', key: 'address' },
    { title: 'Email', dataIndex: 'email', key: 'email' },



];

function UserInfo(props) {
    const [orderData, setOrderData] = useState()
    const [fields, setFields] = useState()
    console.log(props)
    //same as ComponentWillMount
    useEffect(() => {
        getData()
    }, [])

    const getData = async () => {
        const res = await axios.get('http://127.0.0.1:8000/api/PersonalInfo', {
            headers: {
                'Authorization': `Bearer ${props.jwt}`
            }
        })
        console.log(res.data)
        setOrderData(res.data)
        setFields([
            {
                name: ['name'],
                value: res.data.name,
            },
            {
                name: ['address'],
                value: res.data.address,
            },
            {
                name: ['email'],
                value: res.data.email,
            },
            {
                name: ['phone'],
                value: res.data.phone,
            }
        ])
    }

    const onFinish = async (values) => {
        console.log('Success:', values);
        try {


            const res = await axios.post('http://127.0.0.1:8000/api/update',
                { ...values },
                {
                    headers: {
                        'Authorization': `Bearer ${props.jwt}`
                    }
                }
            )
            console.log('Profile Updated!', res)
            // console.log(values.concat(cart))
            if (res.status == 200) {
                message.success('Profile Updated!');

                // window.location.replace("http://127.0.0.1:8000/home");
            }
        } catch (error) {
            if (error.response) {
                if(error.response.data.errors.name !==undefined)
                {
                    message.error(error.response.data.errors.name);
                }
                if(error.response.data.errors.address !==undefined)
                {
                     message.error(error.response.data.errors.email);
                }
                if(error.response.data.errors.email !==undefined)
                {
                     message.error(error.response.data.errors.email);
                }
                if(error.response.data.errors.phone !==undefined)
                {
                     message.error(error.response.data.errors.phone);
                }
            } else if (error.request) {
                // The request was made but no response was received
                console.log(error.request);
            } else {
                // Something happened in setting up the request that triggered an Error
                message.error(error);
            }
        }
    };
    const CustomizedForm = ({ fields }) => (
        <Space align="center" direction="vertical" style={{ display: 'flex', justifyContent: 'center', paddingTop: '5vh' }}>

            <Card title='Personal Information' style={{ width: '50vw' }}>

                <Form
                    name="global_state"
                    layout="horizontal"
                    fields={fields}
                    initialValues={{
                        remember: true,
                    }}
                    onFinish={onFinish}
                    labelCol={{
                        span: 8,
                    }}
                    wrapperCol={{
                        span: 10,
                    }}

                >
                    <Form.Item
                        name="name"
                        label="name"

                        rules={[
                            {

                                message: 'Username is required!',
                            },
                        ]}
                    >
                        <Input />
                    </Form.Item>

                    <Form.Item
                        name="email"
                        label="email"
                        rules={[
                            {
                                required: true,
                                message: 'Email is required!',
                            },
                        ]}
                    >
                        <Input />
                    </Form.Item>

                    <Form.Item
                        name="address"
                        label="address"
                        rules={[
                            {
                                required: true,
                                message: 'Address is required!',
                            },
                        ]}
                    >
                        <Input />
                    </Form.Item>

                    <Form.Item
                        name="phone"
                        label="phone"
                        rules={[
                            {
                                required: true,
                                message: 'Phone is required!',
                            },
                        ]}
                    >
                        <Input />
                    </Form.Item>
                    <Form.Item
                        wrapperCol={{
                            offset: 8,
                            span: 16,
                        }}
                    >
                        <Button type="primary" htmlType="submit">
                            Submit
                        </Button>
                    </Form.Item>
                </Form>
            </Card>
        </Space>


    );


    return (
        <>
            <CustomizedForm
                fields={fields}

            />

        </>


    );

}

export default UserInfo;

let root = document.getElementById('userinfo')
if (root) {
    ReactDOM.render(<UserInfo {...(root.dataset)} />, root);
}