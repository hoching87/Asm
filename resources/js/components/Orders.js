import React, { useEffect, useState } from 'react';
import ReactDOM from 'react-dom';
import 'antd/dist/antd.css';
import axios from 'axios';
import { Divider, Table, Descriptions, Image } from 'antd';

const columns = [
    { title: 'id', dataIndex: 'id', key: 'id' },
    { title: 'reciever_name', dataIndex: 'reciever_name', key: 'reciever_name' },
    { title: 'reciever_phone', dataIndex: 'reciever_phone', key: 'reciever_phone' },
    { title: 'date_ordered', dataIndex: 'date_ordered', key: 'date_ordered' },
    { title: 'date_delivered', dataIndex: 'date_delivered', key: 'date_delivered' },
    { title: 'status', dataIndex: 'status', key: 'status' },
    {
        title: 'Total',
        dataIndex: 'id',
        key: 'x',
        render: (text, record, index) => {
            let total = 0;
            record.items.forEach((item) => {
                total += item.price * item.quantity
            })
            return (
                'RM' + total
            )
        },
    },
];

function Orders(props) {
    const [orderData, setOrderData] = useState()

    useEffect(() => {
        getData()
    }, [])

    const getData = async () => {
        const res = await axios.get(window.location.origin + '/api/orders', {
            headers: {
                'Authorization': `Bearer ${props.jwt}`
            }
        })
        console.log(res.data)

        //add key as id
        res.data.forEach(order => {
            order.key = order.id
        });
        setOrderData(res.data)
    }

    return (
        <>
            <Table
                columns={columns}
                expandable={{
                    expandedRowRender: record => {
                        let total_price = 0;
                        return (
                            <>
                                {record.items.map(item => {
                                    total_price += item.price
                                    return (

                                        <div key={item.id}>
                                            <Descriptions bordered>
                                                <Descriptions.Item>
                                                    <Image src={`${window.location.origin}/uploads/images/${item.details.bouquetImage}`} width='150'></Image>
                                                </Descriptions.Item>
                                                <Descriptions.Item label="Name">{item.details.bouequetName}</Descriptions.Item>
                                                <Descriptions.Item label="Description">{item.details.bouequetDescription}</Descriptions.Item>
                                                <Descriptions.Item label="Type">{item.details.type}</Descriptions.Item>
                                                <Descriptions.Item label="Quantity">{item.quantity}</Descriptions.Item>
                                                <Descriptions.Item label="Unit Price">RM{item.price}</Descriptions.Item>
                                                <Descriptions.Item label="Total Price">RM{item.price * item.quantity}</Descriptions.Item>
                                            </Descriptions>
                                            <Divider></Divider>
                                        </div>
                                    )
                                })}
                            </>
                        )
                    },
                    rowExpandable: record => record.name !== 'Not Expandable',
                }}
                dataSource={orderData}
            />
        </>
    );
}

export default Orders;

let root = document.getElementById('orders')
if (root) {
    ReactDOM.render(<Orders {...(root.dataset)} />, root);
}