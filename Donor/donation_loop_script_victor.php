<?php if (!empty($donations)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Blood Bank</th>
                        <th>Amount (liters)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($donations as $donation): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($donation['donation_date']); ?></td>
                            <td><?php echo htmlspecialchars($donation['blood_bank_name']); ?></td>
                            <td><?php echo htmlspecialchars($donation['amount']); ?> L</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No donation history available.</p>
        <?php endif; ?>